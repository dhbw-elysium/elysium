$('#modalCourse').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget),
		cid = button.data('cid'),
		cgid = button.data('cgid'),
		title = button.data('title'),
		modal = $(this);

	modal.find('#modalCourse .modal-title').text('Vorlesung bearbeiten: ' + title);
	modal.find('#courseCid').val(cid);
	modal.find('#courseCgid').val(cgid);
	modal.find('#courseTitle').val(title);

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

$('#modalCourseGroup').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget),
		cgid = button.data('cgid'),
		title = button.data('title'),
		modal = $(this);

	modal.find('.modal-title').text('Themenbereich bearbeiten: ' + title);
	modal.find('#courseGroupCgid').val(cgid);
	modal.find('#courseGroupTitle').val(title);

	$('#modalCourseGroup .btn-primary').click(function(e){
		e.preventDefault();
		var token = $('#modalCourseGroup [name=_token]').val(),
			cgid = $('#modalCourseGroup #courseGroupCgid').val(),
			title = $('#modalCourseGroup #courseGroupTitle').val();

		$.ajax({
			type: 'POST',
			url: 'course_group/update',
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
