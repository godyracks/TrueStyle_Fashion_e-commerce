/**
 * @license Copyright (c) 2014-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

import { InlineEditor } from '@ckeditor/ckeditor5-editor-inline';

import { Autoformat } from '@ckeditor/ckeditor5-autoformat';
import { Bold, Italic } from '@ckeditor/ckeditor5-basic-styles';
import { BlockQuote } from '@ckeditor/ckeditor5-block-quote';
import { CloudServices } from '@ckeditor/ckeditor5-cloud-services';
import { Essentials } from '@ckeditor/ckeditor5-essentials';
import { Heading } from '@ckeditor/ckeditor5-heading';
import { Indent } from '@ckeditor/ckeditor5-indent';
import { Link } from '@ckeditor/ckeditor5-link';
import { List } from '@ckeditor/ckeditor5-list';
import { Paragraph } from '@ckeditor/ckeditor5-paragraph';
import { PasteFromOffice } from '@ckeditor/ckeditor5-paste-from-office';
import { TextTransformation } from '@ckeditor/ckeditor5-typing';

// You can read more about extending the build with additional plugins in the "Installing plugins" guide.
// See https://ckeditor.com/docs/ckeditor5/latest/installation/plugins/installing-plugins.html for details.

class Editor extends InlineEditor {
	public static override builtinPlugins = [
		Autoformat,
		BlockQuote,
		Bold,
		CloudServices,
		Essentials,
		Heading,
		Indent,
		Italic,
		Link,
		List,
		Paragraph,
		PasteFromOffice,
		TextTransformation
	];

	public static override defaultConfig = {
		toolbar: {
			items: [
				'heading',
				'|',
				'bold',
				'italic',
				'link',
				'bulletedList',
				'numberedList',
				'|',
				'outdent',
				'indent',
				'|',
				'blockQuote',
				'undo',
				'redo'
			]
		},
		language: 'en'
	};
}

export default Editor;
