import { useBlockProps } from "@wordpress/block-editor";

export default function save() {
	const blockProps = useBlockProps.save();

	return (
		<p {...blockProps}>{"Marsapril Pure – hello from the saved content!"}</p>
	);
}
