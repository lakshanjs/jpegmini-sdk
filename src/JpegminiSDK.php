<?php

namespace LakshanJS\Jpegmini;

class JpegminiSDK
{
    protected string $binaryPath;

    public function __construct(string $binaryPath = '/usr/bin/jpegmini')
    {
        if (!is_executable($binaryPath)) {
            throw new \InvalidArgumentException("JPEGmini binary not found or not executable: $binaryPath");
        }

        $this->binaryPath = $binaryPath;
    }

    public function optimize(string $inputFileOrFolder, array $options = []): array
    {
        if (!file_exists($inputFileOrFolder)) {
            throw new \InvalidArgumentException("Input file or folder does not exist: $inputFileOrFolder");
        }

        $command = escapeshellcmd($this->binaryPath) . ' -f=' . escapeshellarg($inputFileOrFolder);

        if (!empty($options['output'])) {
            $command .= ' -o=' . escapeshellarg($options['output']);
        }

        if (isset($options['recursive'])) {
            $command .= ' -r=' . ($options['recursive'] ? '1' : '0');
        }

        if (isset($options['log_level'])) {
            $level = (int) $options['log_level'];
            if (!in_array($level, [0, 1, 2])) {
                throw new \InvalidArgumentException("Invalid log_level. Allowed values: 0, 1, 2");
            }
            $command .= ' -lvl=' . $level;
        }

        if (!empty($options['logfile'])) {
            $command .= ' -logfile=' . escapeshellarg($options['logfile']);
        }

        if (!empty($options['csvfile'])) {
            $command .= ' -csvfile=' . escapeshellarg($options['csvfile']);
        }

        if (!empty($options['resize'])) {
            if (!preg_match('/^\d{1,2}$|^\d{2,5}x\d{2,5}$/', $options['resize'])) {
                throw new \InvalidArgumentException("Invalid resize value. Use percentage (1-99) or widthxheight.");
            }
            $command .= ' -rsz=' . escapeshellarg($options['resize']);
        }

        if (isset($options['quality_mode'])) {
            $qm = (int) $options['quality_mode'];
            if (!in_array($qm, [0, 1, 2])) {
                throw new \InvalidArgumentException("Invalid quality_mode. Allowed values: 0, 1, 2");
            }
            $command .= ' -qual=' . $qm;
        }

        if (isset($options['skip_high_compression'])) {
            $command .= ' -shc=' . ($options['skip_high_compression'] ? '1' : '0');
        }

        if (isset($options['remove_metadata'])) {
            $command .= ' -rmt=' . ($options['remove_metadata'] ? '1' : '0');
        }

        exec($command . ' 2>&1', $output, $exitCode);

        if ($exitCode !== 0) {
            throw new \RuntimeException("JPEGmini failed with exit code $exitCode:\n" . implode("\n", $output));
        }

        return [
            'status'  => 'success',
            'command' => $command,
            'output'  => $output
        ];
    }
}
