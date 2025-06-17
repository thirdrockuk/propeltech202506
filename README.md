# PropelTech technical assessment
This is a barebones Symfony API Platform implementation with one business class

## Development process

### Step 1: Install Symfony API Platform
- `mkdir ~/propeltech`
- Download API Platform from https://github.com/api-platform/api-platform/releases/latest (v4.1.0, tar.gz) and copy into `~/propeltech`
- `cd ~/propeltech`
- `tar -xvzf api-platform-4.1.0.tar.gz`
- `mv api-platform-4.1.0/{.,}* .`
- `rmdir api-platform-4.1.0`
- `rm api-platform-4.1.0.tar.gz`
- `sudo docker compose build --no-cache`
- `sudo docker compose up -d`
- **OUTCOME** 
  - A standard Symfony API Platform is available at https://localhost
  - From https://api-platform.com/docs/symfony/: "You'll need to add a security exception in your browser to accept the self-signed TLS certificate that has been generated for this container when installing the framework."