# Project Commands

This project uses the following Artisan commands:

## Available Commands

- **Update User Data**: 
  ```bash
  php artisan app:update-user-data
  ```

- **Sync User Attributes**: 
  ```bash
  php artisan sync:user-attributes
  ```

## Command Descriptions

- `app:update-user-data`: This command updates user data using Faker-generated data.
- `sync:user-attributes`: This command synchronizes user attributes with a third-party provider.

## API Configuration

The API URL used in the project is defined in the `.env` file:
- **API URL**: `THIRD_PARTY_API_URL=https://run.mocky.io/v3/16cb6ec1-a8ba-4da6-ba2a-d7043e59872e`
