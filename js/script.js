function searchFor(evt, query, page) {
	var keycode = evt.which;
	if(keycode==13) {
		page = page || "musicians";
		window.location="?page="+page+"&q="+query;
		getSearchResults(query, page, category);
	}
}
