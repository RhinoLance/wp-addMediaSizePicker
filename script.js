function copyToClipboard( value ) {
	navigator.permissions.query({name: "clipboard-write"}).then(result => {
		if (result.state == "granted" || result.state == "prompt") {
			navigator.clipboard.writeText(value).then(function() {
				console.log( "Path copied to clipboard: " + value);
				/* clipboard successfully set */
			}, function() {
				/* clipboard write failed */
			});
		}
	});
}