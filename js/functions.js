function getPrediction(parameter){
    var values = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		prefetch: '../data/prefetch/'+parameter+'.json',
		remote: {
			url: 'functions/typeahead.php?'+parameter+'=%QUERY',
			wildcard: '%QUERY'
		}
	});
    return values;
}