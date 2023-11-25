import { __ } from "@wordpress/i18n";

import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

import "./editor.css";

export default function Edit() {
	const blockProps = useBlockProps();

	return (
		<p {...blockProps}>
			{__("Marsapril Pure – hello from the editor!", "marsapril-pure")}
		</p>
	);
}
