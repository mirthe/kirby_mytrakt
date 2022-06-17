# Kirby Plugin: MyTrakt

This plugin allows you to show recently watched and favorite shows and movies for a Trakt account on your Kirby site

## Git submodule

```
git submodule add https://github.com/mirthe/kirby_mytrakt site/plugins/mytrakt
```

## Usage

Add your Trakt API key and username to your config

    'trakt.apiKey'      => 'xxx',
    'trakt.username'    => 'xxx',

For the images, add your API key for https://www.themoviedb.org/ to your config

    'themoviedb.apiKey'  => 'yyy',

Include one or more of the following snippets to display your movies or shows on a page

    <?php snippet('trakt-movies-watched'); ?>
    <?php snippet('trakt-episodes-watched'); ?>

    <?php snippet('trakt-favmovies'); ?>
    <?php snippet('trakt-favshows'); ?>

## Example 

<img src="example-episodes.png" alt="Example episodes">

## Todo

- Offer as an official Kirby plugin
- Add translations for labels
- Add sample SCSS to this readme
- Cleanup code
- Lots..
