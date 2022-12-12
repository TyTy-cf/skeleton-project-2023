
Change php version in file **php-version** if needed, then :

```
symfony composer install
```


```
yarn install
```

---

For CKEditor :

(Mandatory, even with the previous commands)

```
symfony console ckeditor:install
```

```
symfony console assets:install public
```

---

Available bundles  :
- CKEditor
- Captcha
- KnpPaginator
- Lexik Form Filter

---

Available utilities :
- A custom FileUploader
- In assets/scripts/collection_form : to handle form collection

To use the script and have it working :

- In the "CollectionType" field in FormType, you need to add this

```php
'attr' => [
    'data-list-selector' => 'YOUR_KEY_NAME'
],
```

- Add a "ButtonType" right after, like this :

```php
->add('buttonAddENTITY_NAME', ButtonType::class, [
    'label' => 'YOUR LABEL',
    'attr' => [
        'class' => 'btn btn-primary',
        'data-btn-selector' => 'YOUR_KEY_NAME',
    ]
])
```

The _'data-list-selector'_ and the _'data-btn-selector'_ has to match their values to make the script working.

---

For the front part :
- Bootstrap 5 is added, you can find it in "assets/shared/styles/lib"
- FontAwsome 6 is fully added as **free**
- A default template for pagination fom KnpPaginator is made, feel free to custom it

---

Change the Git Origin :

Open the file in : ".git/config" with Notepad++

You will find a line like this :

```text
[remote "origin"]
	url = git@github.com:TyTy-cf/symfony-skeleton-project.git
```

Change the URL to yours and save !
