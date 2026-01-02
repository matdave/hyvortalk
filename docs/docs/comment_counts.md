---
sidebar_position: 3
---

# Comment Counts    

The Hyvor Talk Extra provides a simple way to display comment counts for your pages in MODX.

## Usage

To display the comment count for a specific page, you can use the following snippet call in your templates or resources:

```html
[[!htCommentCounts]]
```

This will render the Hyvor Talk comment count where the snippet is called.

## Configuration Options


| Setting    | Default                    | Description                                                                                                                                          |
|------------|----------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`     | `[[*id]]`                  | The unique identifier for the page where the comment section is displayed. (This may vary if you use a different `hyvortalk.page_identifier` setting |
| `tpl`      | `hyvortalk-comment-counts` | The chunk name used to render the comment section. You can use a custom chunk to change the appearance of the comments.                              |
| `addJS`    | `1`                        | Set to `1` to include the necessary JavaScript for Hyvor Talk. Set to `0` if you want to include the JS manually in your template.                   |
| `language` | `[[++cultureKey]]`         | The language code for the comment section. This should match the language codes supported by Hyvor Talk.                                             |
| `mode`     | `number`                   | The the mode of the comment count. Possible values are "number" and "text". See https://talk.hyvor.com/docs/comment-counts#text-number               |
