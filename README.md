# MASK Wordpress Setup
- Clone repo
- Init Wordpress as a submodule by running `git submodule update --init --recursive`
- Install NVM
- Install stable Node via NVM (7.4.0)
- Run `nvm use` to pull node version from .nvmrc
- Update your creds in wp-config.php
- Install Gulp globally - `npm install gulp -g`
- cd to Mask theme dir at `/wp-content/themes/mask`
- `npm install` or `yarn` if you're one of the cool kids
- Start MAMP
- Run `gulp` in the theme dir to serve and watch

#### Notes
- Image paths in SASS are hard-coded right now, and will need to be updated for deployment to mirror the actual path
- Zeppelin files at: https://app.zeplin.io/project.html#pid=58e4165aede24e07df3a09d4