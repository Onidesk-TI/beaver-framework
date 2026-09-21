<?php

/**
 * Beaver Framework — Modern PHP framework with a plugin ecosystem.
 *
 * @package    Beaver Framework
 * @version    0.1.0
 * @author     Franco <onidesk@outlook.com>
 * @copyright  2026 Onidesk
 * @license    GPL-3.0-or-later <https://www.gnu.org/licenses/gpl-3.0.txt>
 * @link       https://github.com/Onidesk-TI/beaver-framework
 */
$pageTitle = 'Linguagens (i18n)';
$pageSubtitle = 'Traduções com ficheiros PHP, deteção de idioma e helpers globais';
$activeSlug = 'i18n';
require __DIR__ . '/partials/head.php';
?>

<section class="beaver-section">
    <h2><i class="fas fa-folder-tree"></i>Estrutura</h2>
    <div class="beaver-card">
        <pre><code class="language-bash">src/I18n/
├── Translator.php     # Classe principal
├── Locale.php         # Deteção do idioma do browser
└── helpers.php        # Funções globais __() e _e()

lang/
├── pt.php
└── en.php</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-file-code"></i>Ficheiros de tradução</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// lang/pt.php
return [
    'welcome'     => 'Bem-vindo',
    'greeting'    => 'Olá, :name!',
    'items.count' => 'Tens :count item|Tens :count itens',
    'errors.404'  => 'Página não encontrada',
];</code></pre>
        <pre><code class="language-php">// lang/en.php
return [
    'welcome'     => 'Welcome',
    'greeting'    => 'Hello, :name!',
    'items.count' => 'You have :count item|You have :count items',
    'errors.404'  => 'Page not found',
];</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-language"></i>Translator</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// src/I18n/Translator.php
namespace Beaver\I18n;

class Translator
{
    private array $loaded = [];
    private string $locale;
    private string $fallback;

    public function __construct(
        private string $langPath,
        string $locale = 'pt',
        string $fallback = 'pt',
    ) {
        $this->locale   = $locale;
        $this->fallback = $fallback;
    }

    public function get(string $key, array $replace = [], ?string $locale = null): string
    {
        $locale ??= $this->locale;
        $line = $this->load($locale)[$key] ?? null;

        if ($line === null && $locale !== $this->fallback) {
            $line = $this->load($this->fallback)[$key] ?? null;
        }

        return $line === null ? $key : $this->replace($line, $replace);
    }

    public function choice(string $key, int $count, array $replace = []): string
    {
        $line  = $this->get($key, $replace);
        $parts = explode('|', $line);

        if (count($parts) === 1) {
            return $this->replace($parts[0], $replace + ['count' => $count]);
        }

        $form = $count === 1 ? $parts[0] : $parts[1];

        return $this->replace($form, $replace + ['count' => $count]);
    }

    private function load(string $locale): array
    {
        if (isset($this->loaded[$locale])) {
            return $this->loaded[$locale];
        }

        $file = rtrim($this->langPath, '/') . '/' . $locale . '.php';

        if (!is_file($file)) {
            return $this->loaded[$locale] = [];
        }

        $data = require $file;

        return $this->loaded[$locale] = is_array($data) ? $data : [];
    }

    private function replace(string $line, array $replace): string
    {
        foreach ($replace as $k => $v) {
            $line = str_replace(':' . $k, (string) $v, $line);
        }
        return $line;
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-globe"></i>Deteção de idioma</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// src/I18n/Locale.php
namespace Beaver\I18n;

class Locale
{
    public const SUPPORTED = ['pt', 'en'];

    public static function fromBrowser(?string $acceptLanguage = null): string
    {
        $header = $acceptLanguage ?? ($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'pt');

        preg_match_all('/([a-z]{2})(?:-[A-Z]{2})?(?:;q=([0-9.]+))?/i', $header, $m, PREG_SET_ORDER);

        $candidates = [];
        foreach ($m as $match) {
            $lang = strtolower($match[1]);
            $q    = isset($match[2]) && $match[2] !== '' ? (float) $match[2] : 1.0;
            $candidates[$lang] = max($candidates[$lang] ?? 0, $q);
        }

        arsort($candidates);

        foreach (array_keys($candidates) as $lang) {
            if (in_array($lang, self::SUPPORTED, true)) {
                return $lang;
            }
        }

        return 'pt';
    }
}</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-window-restore"></i>Utilização</h2>
    <div class="beaver-card">
        <pre><code class="language-php">use Beaver\I18n\Translator;
use Beaver\I18n\Locale;

$translator = new Translator(
    langPath: __DIR__ . '/../lang',
    locale:   Locale::fromBrowser(),
    fallback: 'pt',
);

echo $translator->get('welcome');
echo $translator->get('greeting', ['name' => 'José']);
echo $translator->choice('items.count', 3);</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-code"></i>Helpers globais</h2>
    <div class="beaver-card">
        <pre><code class="language-php">// src/I18n/helpers.php
if (!function_exists('__')) {
    function __(string $key, array $replace = []): string
    {
        return Translator::instance()->get($key, $replace);
    }
}

if (!function_exists('_e')) {
    function _e(string $key, array $replace = []): void
    {
        echo __($key, $replace);
    }
}</code></pre>
        <pre><code class="language-php">// Numa view
&lt;?= __( 'welcome' ) ?&gt;
&lt;?php _e('greeting', ['name' =&gt; 'José']); ?&gt;</code></pre>
    </div>
</section>

<section class="beaver-section">
    <h2><i class="fas fa-vial"></i>Testar</h2>
    <div class="beaver-card">
        <pre><code class="language-bash"># mudar de idioma no browser e verificar
php beaver serve

# testar a deteção
curl -H "Accept-Language: en-US,en;q=0.9" http://localhost:8000/</code></pre>
    </div>
</section>

<?php require __DIR__ . '/partials/foot.php'; ?>
