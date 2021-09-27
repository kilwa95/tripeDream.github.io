import $ from 'jquery';

$(document).ready(function() {
	var $tagsCollectionHolder = $('div.tarif');

	$tagsCollectionHolder.data('index', $tagsCollectionHolder.find('input').length);
	console.log($tagsCollectionHolder);
	$('body').on('click', '.add_item_link', function(e) {
		var $collectionHolderClass = $(e.currentTarget).data('collectionHolderClass');
		addFormToCollection($collectionHolderClass);
	});

	// add a delete link to all of the existing tag form li elements
	$collectionHolder.find('li').each(function() {
		addTagFormDeleteLink($(this));
	});
});

function addFormToCollection($collectionHolderClass) {
	var $collectionHolder = $('.' + $collectionHolderClass);
	var prototype = $collectionHolder.data('prototype');
	var index = $collectionHolder.data('index');
	var newForm = prototype;
	newForm = newForm.replace(/__name__/g, index);
	$collectionHolder.data('index', index + 1);
	var $newFormLi = $('<div></div>').append(newForm);
	$collectionHolder.append($newFormLi);
	// add a delete link to the new form
	addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
	var $removeFormButton = $('<button class="btn btn-danger mb-5" type="button">Supprimer ce tarif</button>');
	$tagFormLi.append($removeFormButton);

	$removeFormButton.on('click', function(e) {
		// remove the li for the tag form
		$tagFormLi.remove();
	});
}
