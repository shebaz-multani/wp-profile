(function( $ ) {
	'use strict';

	/**
	 * All of the code for shortcode JavaScript source should reside in this file.
	 */
	
	//Make all multi select to select2
	$('select[multiple]').select2({
		placeholder: 'Select an option'
	});


	//Sorting
	$(document).on('click', '.wp-profile-tbl .sort', function(e) {
		let orderField = $('.wp-profile-filter-frm input[name="order"]');
		let order = orderField.val();
		if (order == 'DESC') {
			order = 'ASC';
		} else {
			order = 'DESC';
		}
		orderField.val(order);
		$(this).removeClass('DESC').removeClass('ASC').addClass(order);
		$('.wp-profile-filter-frm').trigger('submit');
	});

	//Pagination
	$(document).on('click', '.wp-profile-pagination a', function(e) {
		e.preventDefault();
		let page = $(this).attr('href');
		let pageField = $('.wp-profile-filter-frm input[name="paged"]');
		pageField.val(page);
		$('.wp-profile-filter-frm').trigger('submit');
	});

	//Handle form submission using ajax
	$(document).on('submit', '.wp-profile-filter-frm', function(e) {
		e.preventDefault();
		let $this = $(this);
		let frmData = $this.serialize();
		let mainEL = $('.wp-profile-main');
		mainEL.addClass('loading');
		$.ajax({
			method: 'POST',
			url: wpprofile_js.ajaxurl,
			data: frmData,
			success: function( response ) {
				let resp = $.parseJSON( response );
				console.log('resp');
				console.log(resp);
				if (resp.status == 'success') {
					$('.wp-profile-listing-main').html(resp.html);
				} else {
					alert(resp.message);
				}
			},
			error: function(xhr, status, error) {
				alert(error);
			},
			complete: function() {
				mainEL.removeClass('loading');
			}
		});
	});

	//Reset pagination and order field value
	$('.wp-profile-filter-frm .form-control').on('input change', function () {
		$('.wp-profile-filter-frm input[name="order"]').val('ASC');
		$('.wp-profile-filter-frm input[name="paged"]').val('1');
	});

	//Show lable on age range field change
	$('.wp-profile-filter #ageLabel').text($('.wp-profile-filter #age').val());
	$('.wp-profile-filter #age').on('input change', function () {
		$('.wp-profile-filter #ageLabel').text($(this).val());
	});


})( jQuery );