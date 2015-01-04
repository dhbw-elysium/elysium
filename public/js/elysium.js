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

    $('#modalUserPassword').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            uid = button.data('uid'),
            modal = $(this);

        modal.find('#modalUserPassword [name=userPasswordUid]').val(uid);

        $('#modalUserPassword .btn-primary').click(function (e) {
            e.preventDefault();
            var passwordField = $('#modalUserPassword [name=password]'),
                passwordConfirmField = $('#modalUserPassword [name=passwordConfirm]'),
                token = $('#modalUserPassword [name=_token]').val(),
                password = passwordField.val(),
                passwordConfirmation = passwordConfirmField.val(),
                uid = $('#modalUserPassword [name=userPasswordUid]').val();

            if (password != passwordConfirmation) {
                $.toaster({
                    title: 'Benutzer',
                    priority: 'danger',
                    message: 'Die Eingaben in den beiden Passwort-Feldern stimmen nicht überein'
                });

                passwordField.val('');
                passwordConfirmField.val('');

            } else {
                $.ajax({
                    type: 'POST',
                    url: 'update/password',
                    data: {
                        _token: token,
                        userUid: uid,
                        userPassword: password
                    },
                    complete: function (jqXHR, status) {
                        if (status == 'success') {
                            $('#modalUserPassword').hide();
                            $.toaster({
                                title: 'Benutzer',
                                priority: 'success',
                                message: 'Das Passwort wurde aktualisiert'
                            });

                        } else {
                            $.toaster({
                                title: 'Benutzer',
                                priority: 'danger',
                                message: 'Das Passwort konnte nicht aktualisiert werden'
                            });
                        }
                    }
                });
            }
        });
    });

	$('#modalPhoneNumber').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			did = parseInt(button.data('did')),
			isPrivate = button.data('private'),
			modal = $(this);

	  	$('#modalPhoneNumber .form-number-elements').empty();
		modal.find('[name=is_private]').val(isPrivate);

		var numberTemplate	= function(type, number, pid) {
			if (!number) {
				number = '';
			}
			if (!pid) {
				pid = '';
			}

			var template = '<div class="row">'+
				  '<div class="col-sm-12">'+
					  '<div class="form-inline">'+
						'<div class="form-group">'+
							'<select class="form-control" name="type[]">';
			template +=		  '<option value="mobile"';
			if (type == 'mobile') {
				template	+= ' selected';
			}
			template +=		  '>Mobil</option>'+
							  '<option value="phone"';
			if (type == 'phone') {
				template	+= ' selected';
			}
			template +=		  '>Festnetz</option>'+
							  '<option  value="fax"';
			if (type == 'fax') {
				template	+= ' selected';
			}
			template +=		  '>Fax</option>'+
							'</select>'+
						'</div> '+
						 '<div class="form-group">'+
							'<input type="text" class="form-control" name="number[]" placeholder="Telefonnummer" value="'+number+'">'+
							'<input type="hidden" name="pid[]" value="'+pid+'" class="pid">'+
						'</div>'+
						'<div class="form-group button-remove-number">'+
							'<button type="button" class="btn btn-danger">'+
							  '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>'+
							'</button>'+
						'</div>'+
					  '</div>'+
				  '</div>'+
			  '</div> ';

			return template;
		};

		var addNumber = function(type, number, pid) {
		  	$('#modalPhoneNumber .form-number-elements').append(numberTemplate(type, number, pid));

			$('#modalPhoneNumber .form-number-elements .btn-danger').click(function(e) {
				e.preventDefault();
				var pid	= $(this).parent().parent().find('input.pid').val();
				$(this).parent().parent().parent().parent().remove();
				if (pid) {
			  		$('#modalPhoneNumber .form-number-elements').append('<input type="hidden" name="delete[]" value="'+pid+'">');
				}
			});
		};

		var urlUpdate	= did+'/phone-'+(isPrivate ? 'private' : 'company')+'.json';
		$.getJSON( urlUpdate, function( data ) {
			$.each( data, function( key, val ) {
				addNumber(val.type, val.number, val.pid);
			});
		});

		$('#modalPhoneNumber .btn-success').click(function (e) {
			e.preventDefault();
			addNumber(null, '');
		});


		$('#modalPhoneNumber .btn-primary').click(function (e) {
			e.preventDefault();
			var token = $('#modalPhoneNumber [name=_token]').val();

			$.ajax({
				type: 'POST',
				url: 'phone-update',
				data: $(this).parent().parent().serializeArray(),
				complete: function (jqXHR, status) {
					$('#modalPhoneNumber').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Beim speichern der Telefon-Nummern ist ein Fehler aufgetreten'
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


