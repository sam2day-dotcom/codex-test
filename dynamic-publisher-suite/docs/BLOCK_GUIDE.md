# Block Creation Guide

1. Add block metadata in `src/blocks/<block>/block.json`.
2. Add editor implementation and shared controls from `src/controls`.
3. Add PHP renderer class under `includes/Blocks`.
4. Register render callback and enqueue assets conditionally.
5. Add SCSS partial and include in style entry.
