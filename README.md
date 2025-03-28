# 🧠 JPEGmini PHP SDK

A lightweight, production-ready PHP SDK wrapper for the [JPEGmini Server CLI](https://jpegmini.com/products/developers/aws/docs). It allows you to optimize JPEG images via command line directly from PHP, with support for resizing, quality settings, metadata removal, and more.

---

## 📦 Installation

Install using Composer:

```bash
composer require lakshanjs/jpegmini-sdk
```

---

## 🚀 Quick Start

```php
use LakshanJS\Jpegmini\JpegminiSDK;

$jpegmini = new JpegminiSDK('/usr/local/bin/jpegmini');

$result = $jpegmini->optimize('/path/to/input.jpg', [
    'output' => '/path/to/output.jpg',
    'resize' => '60',
    'quality_mode' => 1,
    'remove_metadata' => true,
    'skip_high_compression' => false
]);

print_r($result);
```

---

## ⚙️ Options

| Option                     | Type      | Description |
|----------------------------|-----------|-------------|
| `output`                   | `string`  | File or folder path where the optimized image(s) should be saved. If omitted, JPEGmini saves to the same folder as the input, appending `_mini` to the filename. |
| `recursive`                | `bool`    | When optimizing a folder, determines whether subdirectories should be processed. Default: `true` |
| `logfile`                  | `string`  | Path to save JPEGmini logs (same as CLI `-logfile`) |
| `log_level`                | `int`     | CLI log verbosity: `0` (none), `1` (basic), `2` (verbose). Default: `1` |
| `csvfile`                  | `string`  | Path to save CSV summary of optimization results |
| `resize`                   | `string`  | Resize before optimization. Format: `'50'` (percentage) or `'800x600'` (fixed size) |
| `quality_mode`             | `int`     | Output quality: `0` (best), `1` (high), `2` (medium). Default: `0` |
| `skip_high_compression`    | `bool`    | Skips images already heavily compressed. Default: `true` |
| `remove_metadata`          | `bool`    | Removes EXIF and other metadata from JPEG files. Default: `false` |

---

## 📝 Examples

### ➕ Optimize and Save with New Name
```php
$jpegmini->optimize('/images/photo.jpg', [
    'output' => '/images/photo_compressed.jpg',
]);
```

### 🔄 Overwrite Original File (⚠️ Destructive)
```php
$jpegmini->optimize('/images/photo.jpg', [
    'output' => '/images/photo.jpg'
]);
```

### 🧩 Resize & Remove Metadata
```php
$jpegmini->optimize('/images/original.jpg', [
    'resize' => '800x600',
    'remove_metadata' => true
]);
```

### 📁 Optimize Entire Folder (Recursively)
```php
$jpegmini->optimize('/images/uploads', [
    'recursive' => true
]);
```

---

## ✅ Requirements

- PHP 7.4 or higher
- JPEGmini Server installed and accessible via CLI
- Executable binary path (e.g. `/usr/local/bin/jpegmini`)

---

## 📄 License

MIT License — free for commercial and personal use.

---

## 🙋‍♂️ Author

**Lakshan Jayasinghe**  
[GitHub @lakshanjs](https://github.com/lakshanjs)

---

## 📬 Contributing

Pull requests and suggestions are welcome! If you want to add Laravel integration, batch queue support, or auto-backup before overwrite, feel free to fork or raise an issue.

---

## 💡 Tip

This SDK doesn’t use any HTTP calls or external services — it's a direct wrapper around the JPEGmini CLI. It’s ideal for secure, offline image processing systems.

---
