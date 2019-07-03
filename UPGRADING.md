# Upgrading

Upgrade guide for major versions which have breaking changes.

## 3.0

### Required

Only one step required for upgrading to _Froala 3_:

```bash
composer require froala/nova-froala-field
```

Done!

Font Awesome has been removed in 3.0 as required dependency.
So, you can delete your `public/vendor/nova/fonts/font-awesome` directory.
If you want to use _Font Awesome 5_, please read the [instruction](README.md#font-awesome-5).

### Additional

1. Toolbar Buttons configuration format has been changed in 3.0 version.
   You can check new format in the lateset config file version: [config file](https://github.com/froala/nova-froala-field/blob/master/config/froala-field.php)
2. If you use any 3rd party plugins such as: Embed.ly, SCAYT Web SpellChecker... make force republish:
   ```bash
   php artisan vendor:publish --tag=nova-froala-field-plugins --force
   ```
3. If you use _Aviary_ plugin, it's currently not supported in 3.0 version, instead of _Aviary_,
   you can use _TUI Advanced Image Editor_, check out the [instruction](README.md#tui-advanced-image-editor)
4. If you previously setup _Custom Event Handlers_, in 3.0 version api has been changed,
   check out the new version [here](README.md#custom-event-handlers)

**Note**:
If you have made any advanced customizations, please check official upgrade guide - [https://www.froala.com/wysiwyg-editor/docs/migrate-from-v2](https://www.froala.com/wysiwyg-editor/docs/migrate-from-v2).

