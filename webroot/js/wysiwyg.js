Croogo.Wysiwyg.choose = function(url, title, description) {
	window.top.opener.$('#cke_69_textInput').val(Croogo.Wysiwyg.uploadsPath + url);
	window.top.close();
}