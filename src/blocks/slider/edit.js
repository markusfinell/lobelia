import { __ } from "@wordpress/i18n";

import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

import "./editor.css";

export default function Edit() {
	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		allowedBlocks: ["core/group", "core/cover"],
	});

	return <div {...innerBlocksProps} />;
}
