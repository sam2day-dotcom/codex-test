# Dynamic Publisher Suite

Production-grade modular Gutenberg block platform focused on dynamic publishing layouts.

## Roadmap
1. Core architecture and module contracts
2. Shared systems (query, style engine, inspector controls)
3. Block factory + registration pipeline
4. Slider block (initial premium-grade feature)
5. Updater and release engineering
6. Pro layer and integrations

## Current implementation
- Dynamic `dps/slider` block with server-side rendering.
- Shared query engine + transient caching.
- Conditional frontend assets.
- GitHub release updater service.

## Development
```bash
npm install
npm run start
npm run build
```

## Release
Use GitHub Releases with semantic tags (`v1.0.1`) and upload compiled ZIP artifact.
