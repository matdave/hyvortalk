---
sidebar_position: 2
---

# Comments

The Hyvor Talk Extra provides a simple way to integrate the Hyvor Talk comment section into your MODX website.

## Usage

To add the Hyvor Talk comment section to your pages, you can use the following snippet call in your templates or resources:

```html
[[!htComments]]
```

This will render the Hyvor Talk comment section on the page where the snippet is called.

## Add Single Sign-On (SSO) Integration

If you have a login system on your website, you can configure Hyvor Talk to use your user authentication. This allows 
users to comment using their existing accounts on your site. To enable this feature, you need to set the following 
system settings:

- `hyvortalk.private_key` - Your Hyvor Talk Private Key, which you can find in the Hyvor Talk Console under Settings > 
  Single Sign-On. (Make sure to set the login URL on the Hyvor Talk Console as well.)
- `hyvortalk.sso_enabled` - Set this to "Yes" to enable Single Sign-On (SSO) integration.

With SSO enabled, Hyvor Talk will use your website's authentication system to manage user logins and comments.

For more information on configuring Hyvor Talk SSO and its features, refer to the [Hyvor Talk Documentation](https://talk.hyvor.com/docs/sso).

## Additional Configuration Options

| Setting     | Default              | Description                                                                                                                                          |
|-------------|----------------------|------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `[[*id]]`            | The unique identifier for the page where the comment section is displayed. (This may vary if you use a different `hyvortalk.page_identifier` setting |
| `tpl`       | `hyvortalk-comments` | The chunk name used to render the comment section. You can use a custom chunk to change the appearance of the comments.                              |
| `addJS`     | `1`                  | Set to `1` to include the necessary JavaScript for Hyvor Talk. Set to `0` if you want to include the JS manually in your template.                   |
| `pageTitle` | `[[*pagetitle]]`     | The title of the page where the comment section is displayed.                                                                                        |
| `language`  | `[[++cultureKey]]`   | The language code for the comment section. This should match the language codes supported by Hyvor Talk.                                             |
| `loading`   | `default`            | The loading style for the comment section. Options are `default`, `lazy`, or `manual`. See https://talk.hyvor.com/docs/comments#loading              |
| `settings`  | `{}`                 | JSON encoded settings. See https://talk.hyvor.com/docs/comments#settings                                                                             |
