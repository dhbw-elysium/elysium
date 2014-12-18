$(function () {
	$('#modalCourse').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			cid = button.data('cid'),
			cgid = button.data('cgid'),
			courseTitle = button.data('title'),
			modalTitle,
			modal = $(this);

		if (cid) {
			modalTitle = 'Vorlesung bearbeiten';
		} else {
			modalTitle = 'Vorlesung hinzufügen';
		}

		modal.find('.modal-title').text(modalTitle);
		modal.find('#courseCid').val(cid);
		modal.find('#courseCgid').val(cgid);
		modal.find('#courseTitle').val(courseTitle);

		$('#modalCourse .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalCourse [name=_token]').val(),
				cid = $('#modalCourse #courseCid').val(),
				cgid = $('#modalCourse #courseCgid').val(),
				title = $('#modalCourse #courseTitle').val();

			$.ajax({
				type: 'POST',
				url: 'course/update',
				data: {
					_token: token,
					courseCid: cid,
					courseCgid: cgid,
					courseTitle: title
				},
				complete: function (jqXHR, status) {
					$('#modalCourse').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Vorlesung',
							priority: 'danger',
							message: 'Die angegebenen Daten konnten nicht gespeichert werden!',
							timeout: 5000
						});
					}
				}
			});
		});
	});

	$('#modalCourseDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			cid = button.data('cid'),
			title = button.data('title'),
			modal = $(this);

		modal.find('#courseDeleteCid').val(cid);
		modal.find('#courseDeleteTitle').text(title);

		$('#modalCourseDelete .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalCourseDelete [name=_token]').val(),
				cid = $('#modalCourseDelete #courseDeleteCid').val();

			$.ajax({
				type: 'POST',
				url: 'course/delete',
				data: {
					_token: token,
					courseCid: cid
				},
				complete: function (jqXHR, status) {
					$('#modalCourseDelete').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Vorlesung',
							priority: 'danger',
							message: 'Die Vorlesung konnte nicht gelöscht werden'
						});
					}
				}
			});
		});
	});


	$('#modalCourseGroup').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			cgid = button.data('cgid'),
			courseGroupTitle = button.data('title'),
			modal = $(this);

		if (cgid) {
			modalTitle = 'Themenbereich bearbeiten';
		} else {
			modalTitle = 'Themenbereich hinzufügen';
		}


		modal.find('.modal-title').text(modalTitle);
		modal.find('#courseGroupCgid').val(cgid);
		modal.find('#courseGroupTitle').val(courseGroupTitle);

		$('#modalCourseGroup .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalCourseGroup [name=_token]').val(),
				cgid = $('#modalCourseGroup #courseGroupCgid').val(),
				title = $('#modalCourseGroup #courseGroupTitle').val();

			$.ajax({
				type: 'POST',
				url: 'courseGroup/update',
				data: {
					_token: token,
					courseGroupCgid: cgid,
					courseGroupTitle: title
				},
				complete: function (jqXHR, status) {
					$('#modalCourse').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Themenbereich',
							priority: 'danger',
							message: 'Die angegebenen Daten konnten nicht gespeichert werden!',
							timeout: 5000
						});
					}
				}
			});
		});

	});


	$('#modalCourseGroupDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			cgid = button.data('cgid'),
			title = button.data('title'),
			modal = $(this);

		modal.find('#courseGroupDeleteCgid').val(cgid);
		modal.find('#courseGroupDeleteTitle').text(title);

		$('#modalCourseGroupDelete .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalCourseGroupDelete [name=_token]').val(),
				cgid = $('#modalCourseGroupDelete #courseGroupDeleteCgid').val();

			$.ajax({
				type: 'POST',
				url: 'courseGroup/delete',
				data: {
					_token: token,
					courseGroupCgid: cgid
				},
				complete: function (jqXHR, status) {
					$('#modalCourseGroupDelete').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Themenbereich',
							priority: 'danger',
							message: 'Der Themenbereich konnte nicht gelöscht werden'
						});
					}
				}
			});
		});
	});

	$('#modalStatusDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			sid = button.data('sid'),
			title = button.data('title'),
			modal = $(this);

		modal.find('#statusDeleteSid').val(sid);
		modal.find('#statusDeleteTitle').text(title);

		$('#modalStatusDelete .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalStatusDelete [name=_token]').val(),
				sid = $('#modalStatusDelete #statusDeleteSid').val();

			$.ajax({
				type: 'POST',
				url: 'delete',
				data: {
					_token: token,
					statusSid: sid
				},
				complete: function (jqXHR, status) {
					$('#modalStatusDelete').hide();
					if (status == 'success') {
						//location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Der Status konnte nicht in den Papierkorb verschoben werden'
						});
					}
				}
			});
		});
	});



	$('.import-docent-exclude').change(function (event) {
		var checkbox = $(event.target),
			docentId = parseInt(checkbox.attr('data-docent-id')),
			disabled = false,
			color = 'transparent';

		if (checkbox.prop('checked')) {
			color = '#F8F8F8';
			disabled = true;
		}

		$('.import-docent-' + docentId).css('background-color', color);
		$('.import-docent-' + docentId + ' :input').attr("disabled", disabled);

		checkbox.prop('disabled', false);
	});

	$('#docent-list').bootstrapTable({
		}).on('click-row.bs.table', function (e, row) {
		   window.location.href = 'docent/'+row.did;
	});

	$('#docent-list-toolbar').bootstrapTableFilter({
	filters:[
		{
			field: 'did',    // field identifier
			label: 'ID',    // filter label
			type: 'range'   // filter type
		},
		/*
		{
			field: 'label',
			label: 'Label',
			type: 'search',
			enabled: true   // filter is visible by default
		},
		{
			field: 'role',
			label: 'Role',
			type: 'select',
			values: [
				{id: 'ROLE_ANONYMOUS', label: 'Anonymous'},
				{id: 'ROLE_USER', label: 'User'},
				{id: 'ROLE_ADMIN', label: 'Admin'}
			],
		},
		{
			field: 'username',
			label: 'User Name',
			type: 'search'
		},
		{
			field: 'city',
			label: 'City',
			type: 'ajaxSelect',
			source: 'http://example.com/get-cities.php'
		}
		*/
	]
});

});

function docentStatusFormatter(value, row) {
	return '<i class="glyphicon ' + row.status_glyph + '"></i> ' + value;
}


