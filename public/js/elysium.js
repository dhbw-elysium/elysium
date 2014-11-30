$('#modalCourse').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget),
		cid = button.data('cid'),
		cgid = button.data('cgid'),
		courseTitle = button.data('title'),
		modalTitle,
		modal = $(this);

	if (cid) {
		modalTitle	= 'Vorlesung bearbeiten';
	} else {
		modalTitle	= 'Vorlesung hinzufügen';
	}

	modal.find('.modal-title').text(modalTitle);
	modal.find('#courseCid').val(cid);
	modal.find('#courseCgid').val(cgid);
	modal.find('#courseTitle').val(courseTitle);

	$('#modalCourse .btn-primary').click(function(e){
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
			complete: function(jqXHR, status){
				$('#modalCourse').hide();
				if (status == 'success') {
					location.reload();
				} else {
					$.toaster({ title : 'Vorlesung', priority : 'danger', message : 'Die angegebenen Daten konnten nicht gespeichert werden!', timeout: 5000 });
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

	$('#modalCourseDelete .btn-primary').click(function(e){
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
			complete: function(jqXHR, status){
				$('#modalCourseDelete').hide();
				if (status == 'success') {
					location.reload();
				} else {
					$.toaster({ title : 'Vorlesung', priority : 'danger', message : 'Die Vorlesung konnte nicht gelöscht werden' });
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
		modalTitle	= 'Themenbereich bearbeiten';
	} else {
		modalTitle	= 'Themenbereich hinzufügen';
	}


	modal.find('.modal-title').text(modalTitle);
	modal.find('#courseGroupCgid').val(cgid);
	modal.find('#courseGroupTitle').val(courseGroupTitle);

	$('#modalCourseGroup .btn-primary').click(function(e){
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
			complete: function(jqXHR, status){
				$('#modalCourse').hide();
				if (status == 'success') {
					location.reload();
				} else {
					$.toaster({ title : 'Themenbereich', priority : 'danger', message : 'Die angegebenen Daten konnten nicht gespeichert werden!', timeout: 5000 });
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

	$('#modalCourseGroupDelete .btn-primary').click(function(e){
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
			complete: function(jqXHR, status){
				$('#modalCourseGroupDelete').hide();
				if (status == 'success') {
					location.reload();
				} else {
					$.toaster({ title : 'Themenbereich', priority : 'danger', message : 'Der Themenbereich konnte nicht gelöscht werden' });
				}
			}
		});
	});
});