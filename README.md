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

### Step 2: Configure API Platform to our tastes
- Disable HTTPS: The generation of a signed SSL certificate is out of scope.
- Move from using annotations to using XML for platform configuration: I prefer a separation of code and configuration.
- Move from using underscores in endpoints to using dashes (personal preference).
- Configure API Platform to use standard PUT, so that an entity can be partially updated (personal preference).
- Remove the default migration and Greetings entity.
- **OUTCOME**
  - A reconfigured Symfony API Platform is available at http://localhost
