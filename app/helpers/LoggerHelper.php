<?php

namespace app\helpers;

class LoggerHelper
{
    private const TYPES_PERMITIDOS = ['ok','erro','info','atencao','jump','head'];
    private const CLASSES_IGNORADAS = [self::class]; // pode adicionar outras aqui, ex: 'app\helpers\OutrosHelpers'

    public static function msgAPI(string $msg, string $type = 'info', ?int $nivelStack = null): void
    {
        $type = in_array($type, self::TYPES_PERMITIDOS) ? $type : 'info';
        $callerFormatado = self::formatCaller($nivelStack);
        $timestamp = date('Y-m-d H:i:s');
        $msg = strtoupper($msg);

        if (php_sapi_name() === 'cli') {
            self::renderCLI($msg, $type, $callerFormatado, $timestamp);
        } else {
            self::renderHTML($msg, $type, $callerFormatado, $timestamp);
        }
    }

    private static function formatCaller(?int $nivel): string
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

        // Se nível for informado explicitamente
        if ($nivel !== null && isset($backtrace[$nivel])) {
            $caller = $backtrace[$nivel];
        } else {
            // Busca automaticamente quem está fora das classes ignoradas
            $caller = null;
            foreach ($backtrace as $frame) {
                if (!isset($frame['class'])) continue;
                if (!in_array($frame['class'], self::CLASSES_IGNORADAS)) {
                    $caller = $frame;
                    break;
                }
            }
        }

        if (!$caller) return '[N/A]';

        $class = $caller['class'] ?? '';
        $type  = $caller['type'] ?? '';
        $func  = $caller['function'] ?? '';

        return $class || $func ? "[{$class}{$type}{$func}()]" : '[N/A]';
    }

    private static function renderCLI(string $msg, string $type, string $caller, string $timestamp): void
    {
        echo "\n";

        switch ($type) {
            case 'jump':
                echo CONSTANT('_COR_FONTE_TXT_ROXO') . "\n" . str_repeat($msg, 100) . CONSTANT('_COR_FONTE_TXT_RESET');
                break;

            case 'head':
                echo CONSTANT('_COR_FONTE_TXT_AZUL') . "\n\n" . str_repeat("=", 100) . "\n" . $msg . "\n" . CONSTANT('_COR_FONTE_TXT_RESET');
                break;

            default:
                $mensagem = trim(sprintf('%s %s %s', $timestamp, $caller, $msg));
                $cor = match ($type) {
                    'ok' => CONSTANT('_COR_FONTE_TXT_VERDE'),
                    'atencao' => CONSTANT('_COR_FONTE_TXT_LARANJA'),
                    'erro' => CONSTANT('_COR_FONTE_TXT_VERMELHO'),
                    default => CONSTANT('_COR_FONTE_TXT_BRANCO'),
                };
                echo $cor . $mensagem . CONSTANT('_COR_FONTE_TXT_RESET');
                break;
        }
    }

    private static function renderHTML(string $msg, string $type, string $caller, string $timestamp): void
    {
        echo "<br>";

        switch ($type) {
            case 'jump':
                echo "<br>";
                break;

            case 'head':
                echo "<font class='fonte_padrao'><br><br><hr><br>$msg<br>";
                break;

            default:
                $mensagem = trim(sprintf('%s %s %s', $timestamp, $caller, $msg));
                $class = match ($type) {
                    'ok' => "fonte_padrao cor_fonte_verde",
                    'atencao' => "fonte_padrao cor_fonte_laranja",
                    'erro' => "corfundolinhaVermelho fonte_padrao cor_fonte_branca",
                    default => "fonte_padrao",
                };
                echo "<span class='$class'>$mensagem</span>";
                break;
        }
    }
}
