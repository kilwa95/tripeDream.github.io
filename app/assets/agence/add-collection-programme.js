import $ from 'jquery';

$(document).ready(function() {
	var $tagsCollectionHolder = $('ul.tags');
	$tagsCollectionHolder.data('index', $tagsCollectionHolder.find('input').length);
	$('body').on('click', '.add_item_link', function(e) {
		var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
		addFormToCollection($collectionHolderClass);
	});
});

function addFormToCollection($collectionHolderClass) {
	var $collectionHolder = $('.' + $collectionHolderClass);
	var prototype = $collectionHolder.data('prototype');
	var index = $collectionHolder.data('index');
	var newForm = prototype;
	newForm = newForm.replace(/__name__/g, index);
	$collectionHolder.data('index', index + 1);
	var $newFormLi = $('<li></li>').append(newForm);
	$collectionHolder.append($newFormLi);
}
