$(function(){

	//if portfolio info exists
	if($('#portfolio_info').length > 0){

		var createRow = function(){

			return $('<div/>', {
				'class': 'pm-form-info-row'
			});
		};

		var createKey = function(val){

			var keyItem,
				input;

			keyItem = $('<div/>', {
				'class': 'pm-form-info-key'
			});			

			//append input box
			input = $('<input/>').attr('type', 'text');
			input.appendTo(keyItem);

			//if val is provided
			if(val){
				input.attr('value', val)
			}

			return keyItem;
		};

		var createValue = function(val){

			var valueItem,
				input;

			valueItem = $('<div/>', {
				'class': 'pm-form-info-value'
			});			

			//append input box
			input = $('<input/>').attr('type', 'text');
			input.appendTo(valueItem);

			//if val is provided
			if(val){
				input.attr('value', val)
			}


			return valueItem;
		};

		var createDelete = function(){

			var deleteItem,
				a,
				img;

			deleteItem = $('<div/>', {
				'class': 'pm-form-info-delete'
			});

			//create/append link and img
			img = $('<img/>', {
				'alt': 'Delete-icon',
				'src': '/img/delete-icon.png'
			});

			a = $('<a/>', {
				'alt': 'Delete',
				'href': '#',
				'title': 'Delete'
			}).append(img);

			deleteItem.append(a);

			return deleteItem;
		};


		(function(){

			var pInfo = $('#portfolio_info').val(),
				pArray = pInfo.split('*&*'),
				pForm,
				pRow,
				pKey,
				pValue,
				pDelete,
				pRowData,
				i,
				l;

			if(pInfo != ''){

				//for each array item
				for(i = 0, l = pArray.length; i < l; ++i){

					//create row
					pRowData = pArray[i].split('&val=');

					//store form
					pForm = $('.pm-form-info');

					//create divs
					pRow = createRow();
					pKey = createKey(pRowData[0]);
					pValue = createValue(pRowData[1]);
					pDelete = createDelete();

					//append elements to row
					pRow.append(pKey, pValue, pDelete);

					//append row to form
					pForm.append(pRow);
				}
			}
		})();

		//add a new row to form
		(function(){

			var pForm,
				pRow,
				pKey,
				pValue,
				pDelete;

			//store form
			pForm = $('.pm-form-info');

			//create divs
			pRow = createRow();
			pKey = createKey();
			pValue = createValue();
			pDelete = createDelete();

			//append elements to row
			pRow.append(pKey, pValue, pDelete);

			//append row to form
			pForm.append(pRow);
		})();

		//EVENTS
		$('.new_portfolio, .edit_portfolio').on('submit', function(e){

			var infoForm,
				infoRows,
				infoKey,
				infoVal,
				infoArray = [],
				info,
				i, l;

			//cache vars
			infoForm = $('.pm-form-info');
			infoRows = infoForm.find('.pm-form-info-row');

			//for each row
			for(i = 0, l = infoRows.length; i < l; ++i){

				//get key and value
				infoKey = $(infoRows[i]).find('.pm-form-info-key input').val();
				infoVal = $(infoRows[i]).find('.pm-form-info-value input').val();

				//remove whitespace
				infoKey = infoKey.trim();
				infoVal = infoVal.trim();

				//if both exist, join and add to array
				if(infoKey && infoVal){
					infoArray.push(infoKey + '&val=' + infoVal);
				}

				//check if any rows to save
				if(infoArray.length > 0){

					//join array
					info = infoArray.join('*&*');

					//store array in hidden input
					$('#portfolio_info').val(info);
				}
			}

			//submit form
			e.submit();

			//prevent submit
			e.preventDefault();
		});

		$('.pm-form-info-add a').on('click', function(e){

			var infoForm,
				infoRow,
				infoKey,
				infoValue,
				infoDelete,
				img,
				a;

			//store form
			infoForm = $('.pm-form-info');

			//create divs
			infoRow = createRow();
			infoKey = createKey();
			infoValue = createValue();
			infoDelete = createDelete();

			//append elements to row
			infoRow.append(infoKey, infoValue, infoDelete);

			//append row to form
			infoForm.append(infoRow);

			//prevent submit
			e.preventDefault();
		});

		$('.pm-form-info').on('click', '.pm-form-info-delete a', function(e){

			var parent,
				count;

			//count rows
			count = $('.pm-form-info-row').length;

			//if more than one row, delete parent, otherwise do nothing
			if(count > 1){

				//find parent;
				parent = $(this).parents('.pm-form-info-row');

				//remove parent;
				parent.remove();
			}

			//prevent submit
			e.preventDefault();
		});	
	}
});