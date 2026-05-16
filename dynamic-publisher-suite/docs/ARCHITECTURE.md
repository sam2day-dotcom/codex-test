# Architecture Notes

## Layers
- **Bootstrap**: plugin file + autoloader + service container pattern.
- **Core**: module bootstrapping and lifecycle.
- **Shared Services**: asset manager, query engine, styling engine, updater.
- **Blocks**: each block is isolated and consumes shared services.
- **Pro**: reserved namespace and folder for premium modules.

## Free/Pro Strategy
Free plugin contains base blocks and shared infra. Pro package can inject additional modules via hooks and capability gates.

## Performance strategy
- Dynamic rendering to avoid stale markup.
- Conditional CSS/JS enqueue only when block renders.
- Query transient cache for repeated requests.
- Keep frontend JS vanilla, no jQuery.
