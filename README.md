# DrupalCamp Austin 2013 - Built on Drupal 8

## git remotes

If you clone this and need to update core at some point, please name that remote
```drupal``` and name this FK GitHub repo as ```origin```:

```
drupal  http://git.drupal.org/project/drupal.git (fetch)
drupal  http://git.drupal.org/project/drupal.git (push)
origin  git@github.com:fourkitchens/dca2013.git (fetch)
origin  git@github.com:fourkitchens/dca2013.git (push)
```

## git branches

This repo started out as a clone of Drupal 8.x, so there will be lots of old
branches but its safe to ignore them. Since Drupal doesn't use the ```master```
branch we will use it as our trunk just like any regular project.

Do your work in a feature branch and send a PR to pull it into ```master```
