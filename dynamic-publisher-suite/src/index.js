import { registerBlockType } from '@wordpress/blocks';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, RangeControl, ToggleControl } from '@wordpress/components';
import metadata from './blocks/slider/block.json';

registerBlockType(metadata.name, {
	...metadata,
	edit: ({ attributes, setAttributes }) => {
		const blockProps = useBlockProps();
		return (
			<div {...blockProps}>
				<InspectorControls>
					<PanelBody title="Slider Settings">
						<RangeControl label="Posts" value={attributes.postsPerPage} onChange={(v) => setAttributes({ postsPerPage: v })} min={1} max={12} />
						<ToggleControl label="Autoplay" checked={attributes.autoplay} onChange={(v) => setAttributes({ autoplay: v })} />
					</PanelBody>
				</InspectorControls>
				<p><strong>Dynamic Slider</strong> (preview rendered on frontend).</p>
			</div>
		);
	},
	save: () => null,
});
