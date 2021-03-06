$(function () {

	/**	 Begin bootstrap table override **/
	var calculateObjectValue = function (self, name, args, defaultValue) {
        if (typeof name === 'string') {
            // support obj.func1.func2
            var names = name.split('.');

            if (names.length > 1) {
                name = window;
                $.each(names, function (i, f) {
                    name = name[f];
                });
            } else {
                name = window[name];
            }
        }
        if (typeof name === 'object') {
            return name;
        }
        if (typeof name === 'function') {
            return name.apply(self, args);
        }
        return defaultValue;
    };

	var bootstrapTableExtensions = {
		statusList: [],

		courseList: [],

    	getData: function () {
			return this.data;	//needs to be overwritten because we have no other opportunity to check our manual filters
		},

		initSearch: function () {
			var that = this;

			if (this.options.sidePagination !== 'server') {
				var s = this.searchText && this.searchText.toLowerCase();
				var f = $.isEmptyObject(this.filterColumns) ? null: this.filterColumns;

				// Check filter
				this.data = f ? $.grep(this.options.data, function (item, i) {
					for (var key in f) {
						if (item[key] !== f[key]) {
							return false;
						}
					}
					return true;
				}) : this.options.data;

				s = $('#convert').text(s).html();
				this.data = s ? $.grep(this.data, function (item, i) {
					for (var key in item) {
						key = $.isNumeric(key) ? parseInt(key, 10) : key;
						var value = item[key];

						// Fix #142: search use formated data
						value = calculateObjectValue(that.header,
							that.header.formatters[$.inArray(key, that.header.fields)],
							[value, item, i], value);

						var index = $.inArray(key, that.header.fields);
						if (index !== -1 && that.header.searchables[index] &&
							(typeof value === 'string' ||
							typeof value === 'number') &&
							(value + '').toLowerCase().indexOf(s) !== -1) {
							return true;
						}
					}
					return false;
				}) : this.data;

				//course filter
				if ($('.filter-course').length) {
					that.courseList = [];

					$('.filter-course option:selected').each(function() {
        		        that.courseList.push(parseInt(this.value, 10));
					});

					if (that.courseList.length) {
						this.data = $.grep(this.data, function (item) {
							for (var courseId in item.courses) {
								courseId	= parseInt(courseId, 10);
								if ($.inArray(courseId, that.courseList) != -1) {
									return true;
								}
							}
							return false;
						});
					}
				}

				//status filter
				if ($('.filter-status').length) {
					that.statusList = [];

					$('.filter-status option:selected').each(function() {
        		        that.statusList.push(parseInt(this.value, 10));
					});

					if (that.statusList.length) {
						this.data = $.grep(this.data, function (item) {
							if ($.inArray(parseInt(item.sid, 10), that.statusList) != -1) {
								return true;
							}
							return false;
						});
					}
				}
			}
		}
	};
	$.extend(true, $.fn.bootstrapTable.Constructor.prototype, bootstrapTableExtensions);
	/**	 End bootstrap table override **/


	$('[data-toggle="tooltip"]').tooltip();

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

		modal.find('.btn-primary').unbind('click'); //remove previously attached events to prevent request from being sent twice
		$('#modalCourse .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalCourse [name=_token]').val(),
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
					$(buttonSubmit).prop('disabled', false);
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

		modal.find('.btn-primary').unbind('click');
		$('#modalCourseDelete .btn-primary').click(function (e) {
			$(this).prop('disabled', true);
			e.preventDefault();
			var buttonSubmit = this,
				token = $('#modalCourseDelete [name=_token]').val(),
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
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
						$('#course-list').bootstrapTable('refresh');
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

		modal.find('.btn-primary').unbind('click');
		$('#modalCourseGroup .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalCourseGroup [name=_token]').val(),
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

					$(buttonSubmit).prop('disabled', false);
					if (jqXHR.status == 406) {
						$.toaster({
							title: 'Themenbereich',
							priority: 'danger',
							message: 'Es ist bereits ein Themenbereich mit diesem Namen vorhanden',
							timeout: 5000
						});
					} else if (status == 'success') {
						$('#modalCourse').hide();
						location.reload();
					} else {
						$('#modalCourse').hide();
						location.reload();
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

		modal.find('.btn-primary').unbind('click');
		$('#modalCourseGroupDelete .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalCourseGroupDelete [name=_token]').val(),
				cgid = $('#modalCourseGroupDelete #courseGroupDeleteCgid').val();

			$.ajax({
				type: 'POST',
				url: 'courseGroup/delete',
				data: {
					_token: token,
					courseGroupCgid: cgid
				},
				complete: function (jqXHR, status) {
					$(buttonSubmit).prop('disabled', false);
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

		modal.find('.btn-primary').unbind('click');
		$('#modalStatusDelete .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalStatusDelete [name=_token]').val(),
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
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
						location.reload();
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
    $('#modalStatusRestore').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            sid = button.data('sid'),
            title = button.data('title'),
            modal = $(this);

        modal.find('#statusRestoreSid').val(sid);
        modal.find('#statusRestoreTitle').text(title);

		modal.find('.btn-primary').unbind('click');
        $('#modalStatusRestore .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
            	token = $('#modalStatusRestore [name=_token]').val(),
                sid = $('#modalStatusRestore #statusRestoreSid').val();

            $.ajax({
                type: 'POST',
                url: 'restore',
                data: {
                    _token: token,
                    statusSid: sid
                },
                complete: function (jqXHR, status) {
                    $('#modalStatusRestore').hide();
					$(buttonSubmit).prop('disabled', false);
                    if (status == 'success') {
                        location.reload();
                    } else {
                        $.toaster({
                            title: 'Status',
                            priority: 'danger',
                            message: 'Der Status konnte nicht wiederhergestellt werden'
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

		modal.find('.btn-primary').unbind('click');
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

    $('#modalUserDelete').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            uid = button.data('uid'),
            name = button.data('name'),
            modal = $(this);

        modal.find('#userDeleteUid').val(uid);
        modal.find('#userDeleteName').text(name);

		modal.find('.btn-primary').unbind('click');
        $('#modalUserDelete .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
            	token = $('#modalUserDelete [name=_token]').val(),
                uid = $('#modalUserDelete #userDeleteUid').val();

            $.ajax({
                type: 'POST',
                url: 'delete',
                data: {
                    _token: token,
                    userUid: uid
                },
                complete: function (jqXHR, status) {
                    $('#modalUserDelete').hide();
					$(buttonSubmit).prop('disabled', false);
                    if (status == 'success') {
                        location.reload();
                    } else {
                        $.toaster({
                            title: 'Benutzer',
                            priority: 'danger',
                            message: 'Der Benutzer konnte nicht gelöscht werden'
                        });
                    }
                }
            });
        });
    });

	$('#modalDocentData').on('show.bs.modal', function (event) {
		if (!event.relatedTarget) {
			return;
		}
		var button = $(event.relatedTarget),
			did = parseInt(button.data('did')),
			property = button.data('property'),
			modal = $(this);

		var elementTemplate	= function(type, name, value, label, tooltip) {
			var template =
				'<div class="form-group">'+
					'<label class="col-sm-3 control-label"'+ ((tooltip) ? ' title="'+tooltip +'"': '') +'>'+ label +'</label>' +
					'<div class="col-sm-9">';

			if (type == 'text' || type == 'email') {
            	template = template+'<input type="text" class="form-control" id="'+name+'" name="'+name+'" value="'+value+'" placeholder="(leer)">';
			} else if(type == 'textarea') {
            	template = template+'<textarea class="form-control" id="'+name+'" name="'+name+'" rows="10">'+value+'</textarea>';

			} else if(type == 'boolean') {
            	template = template+'<select class="form-control" id="'+name+'" name="'+name+'">';

            	template = template+'<option value="1"';
				if (value == 1) {
					template = template+'selected="selected"';
				}
				template = template+'>ja</option>';

				template = template+'<option value="0"';
				if (value == 0) {
					template = template+'selected="selected"';
				}
				template = template+'>nein</option>';

				template = template+'</select>';

			} else if(type == 'date') {
				template = template+'<div class="input-group date">'+
  					'<input type="text" class="form-control" value="'+value+'" name="'+name+'"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>'+
				'</div> ';

			}

			template	= template +
				  '</div>'+
			  '</div> ';

			return template;
		};

		modal.find('.modal-body').empty();	//clear form

		$.getJSON(did+'/data-form-'+property+'.json', function( data ) {
			console.log(data);

			$.each( data.elements, function( key, val ) {
				$('#modalDocentData .modal-body').append(elementTemplate(val.type, val.name, val.value, val.label, val.tooltip));
				if (val.type == 'date') {
					$('#modalDocentData .modal-body .input-group.date').datepicker({
						format: "dd.mm.yyyy",
						language: "de"
					});
				}
			});
		});


		modal.find('.btn-primary').unbind('click');
		$('#modalDocentData .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				 token = $('#modalDocentData [name=_token]').val(),
				data = $(this).parent().parent().serializeArray();

			$.ajax({
				type: 'POST',
				url: did+'/data-form-'+property,
				data: data,
				complete: function (jqXHR, status) {
					$(buttonSubmit).prop('disabled', false);
					//$('#modalDocentData').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Beim speichern der Informationen ist ein Fehler aufgetreten'
						});
					}
				}
			});
		});

	});

	$('#modalDocentDelete').on('show.bs.modal', function (event) {
		var modal = $(this);

		modal.find('.btn-primary').unbind('click');
		$('#modalDocentDelete .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this;

			$.ajax({
				type: 'POST',
				url: 'delete',
				data: $(this).parent().parent().serializeArray(),
				complete: function (jqXHR, status) {
					$('#modalDocentDelete').hide();
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
					   window.location.href = '../docents';
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Der Dozent konnte nicht in den Papierkorb verschoben werden'
						});
					}
				}
			});
		});
	});

	$('#modalDocentTime').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			did = button.data('did'),
			modal = $(this);

		modal.find('.btn-primary').unbind('click');
		$('#modalDocentTime .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalDocentTime [name=_token]').val();

			$.ajax({
				type: 'POST',
				url: did+'/data-teach-time',
				data: $(this).parent().parent().serializeArray(),
				complete: function (jqXHR, status) {
					$('#modalPhoneNumber').hide();
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Beim speichern der bevorzugten Vorlesungszeiten ist Fehler aufgetreten'
						});
					}
				}
			});
		});
	});

	$('#modalDocentCourseList').on('show.bs.modal', function (event) {
		var modal = $(this);

		$('#assignedCourse').multiselect({
			//includeSelectAllOption: true,
			enableCaseInsensitiveFiltering: true,
			enableClickableOptGroups: true,
			filterPlaceholder: 'Optionen filtern',
			nonSelectedText: '(keine Vorlesung ausgewählt)',
			selectAllText: ' Alle auswählen',
			nSelectedText: ' ausgewählt',
			allSelectedText: 'Alle ausgewählt',
			numberDisplayed: 4,
			templates: {
				filter: '<li class="multiselect-item filter"><div class="input-group"><input class="form-control multiselect-search" type="text"></div></li>'
			}
		});

		modal.find('.btn-primary').unbind('click');
		$('#modalDocentCourseList .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this;

			$.ajax({
				type: 'POST',
				url: 'update-course-list',
                data: $(this).parent().parent().serializeArray(),
				complete: function (jqXHR, status) {
					$('#modalDocentCourseList').hide();
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Beim speichern zugewiesenen Vorlesungen ist ein Fehler aufgetreten'
						});
					}
				}
			});
		});
	});

	$('#modalPhoneNumber').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			did = parseInt(button.data('did')),
			isPrivate = button.data('private'),
			modalTitle = 'Telefonnummern '+ ((isPrivate) ? '(privat)' : '(geschäftlich)'),
			modal = $(this);

		modal.find('.modal-title').text(modalTitle);


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
							'<button type="button" class="btn btn-default btn-remove">'+
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

			$('#modalPhoneNumber .form-number-elements .btn-remove').click(function(e) {
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

		$('#modalPhoneNumber .btn-add').click(function (e) {
			e.preventDefault();
			addNumber(null, '');
		});


		modal.find('.btn-primary').unbind('click');
		$('#modalPhoneNumber .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalPhoneNumber [name=_token]').val();

			$.ajax({
				type: 'POST',
				url: 'phone-update',
				data: $(this).parent().parent().serializeArray(),
				complete: function (jqXHR, status) {
					$('#modalPhoneNumber').hide();
					$(buttonSubmit).prop('disabled', false);
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

	$('#modalDocentStatus').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			did = button.data('did'),
			sid = button.data('sid'),
			dsid = button.data('dsid'),
			comment = button.data('comment'),
			modal = $(this);

		if (dsid == 0) {
			sid	= 0;
			comment	= '';
		}
		modal.find('#docentUpdateDsid').val(dsid);
		modal.find('#statusSid').val(sid);
		modal.find('#statusComment').val(comment);

		modal.find('.btn-primary').unbind('click');
		$('#modalDocentStatus .btn-primary').click(function (e) {
			e.preventDefault();
			var buttonSubmit	= this,
				token = $('#modalDocentStatus [name=_token]').val(),
				dsid = $('#modalDocentStatus #docentUpdateDsid').val(),
				did = $('#modalDocentStatus  [name=did]').val(),
				sid = $('#modalDocentStatus #statusSid').val(),
				comment = $('#modalDocentStatus #statusComment').val();
			$(buttonSubmit).prop('disabled', true);

			$.ajax({
				type: 'POST',
				url: 'status/update',
				data: {
					_token: token,
					dsid: dsid,
					did: did,
					sid: sid,
					comment: comment
				},
				complete: function (jqXHR, status) {
					//$('#modalDocentStatus').hide();
					$(buttonSubmit).prop('disabled', false);
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Die Statusänderung konnte nicht gespeichert werden'
						});
					}
				}
			});
		});
	});


	$('#modalDocentStatusDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget),
			dsid = button.data('dsid'),
			modal = $(this);

        modal.find('#docentStatusDeleteDsid').val(dsid);


		modal.find('.btn-primary').unbind('click');
		$('#modalDocentStatusDelete .btn-primary').click(function (e) {
			e.preventDefault();
			$(this).prop('disabled', true);
			var buttonSubmit = this,
				token = $('#modalDocentStatusDelete [name=_token]').val(),
				did = $('#modalDocentStatusDelete [name=did]').val(),
				dsid = $('#modalDocentStatusDelete [name=dsid]').val();

			$.ajax({
				type: 'POST',
				url: did+'/status/delete',
				data: {
					_token: token,
					did: did,
					dsid: dsid
				},
				complete: function (jqXHR, status) {
					$(buttonSubmit).prop('disabled', false);
					$('#modalDocentStatusDelete').hide();
					if (status == 'success') {
						location.reload();
					} else {
						$.toaster({
							title: 'Status',
							priority: 'danger',
							message: 'Der Statuseintrag konnte nicht entfernt werden'
						});
					}
				}
			});
		});
	});

	$('.docents-filter-dropdown').multiselect({
		//includeSelectAllOption: true,
		enableCaseInsensitiveFiltering: true,
		enableClickableOptGroups: true,
		filterPlaceholder: 'Optionen filtern',
		nonSelectedText: '(keine Einschränkung)',
		selectAllText: ' Alle auswählen',
		nSelectedText: ' ausgewählt',
		allSelectedText: 'Alle ausgewählt',
		numberDisplayed: 3,
		templates: {
			filter: '<li class="multiselect-item filter"><div class="input-group"><input class="form-control multiselect-search" type="text"></div></li>'
		},
		onChange: function(option, checked) {
			$('#docent-list').bootstrapTable('refresh');
		}
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
		formatSearch: function () {
			return 'Suche nach Vor/Nachname, Vorlesung oder Status';
		}

		}).on('click-row.bs.table', function (e, row) {
			window.location.href = 'docent/'+row.did;
		}).on('load-success.bs.table', function(data) {
			if (!$('#docent-list-clear').length) {
				var searchBar = $('.columns.columns-right.btn-group.pull-right'),
					tpl	= '';
				tpl = tpl + '<button type="button" class="btn btn-default" id="docent-list-clear" title="Filter und Suchfeld zurücksetzen">';
				tpl = tpl + '	  <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>';
				tpl = tpl + '</button>';

			  	searchBar.append(tpl);
				$('#docent-list-clear').click(function (e) {
					e.preventDefault();
					$('.docents-filter-dropdown').multiselect('deselectAll', false);
					$('.docents-filter-dropdown').multiselect('refresh');
					$('.pull-right.search input').val('');
					$('.pull-right.search input').trigger('keyup');
				});

			}
	});


});

function docentStatusFormatter(value, row) {
	return '<i class="glyphicon ' + row.status_glyph + '"></i> ' + value;
}

function courseButtonsFormatter(value, row) {
	var tpl	= '';

	tpl = tpl + '<div class="btn-group" role="group">';
	tpl = tpl + '<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalCourse" data-cid="'+row.cid+'" data-cgid="'+row.cgid+'" data-title="'+row.course_title+'">';
	tpl = tpl + '	  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
	tpl = tpl + '</button>';
	tpl = tpl + '<button type="button" class="btn btn-default btn-remove btn-xs" data-toggle="modal" data-target="#modalCourseDelete" data-cid="'+row.cid+'" data-title="'+row.course_title+'">';
	tpl = tpl + '	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
	tpl = tpl + '</button>';
	tpl = tpl + '</div>';

	return tpl;
}

