jQuery(document).ready(function(){
    const $ = jQuery;
    
    $("#create_data").click(function (event) {
      event.preventDefault();
    
      $.ajax({
        url: script_ajax.ajax_url,
        method: 'post',
        dataType: "html",
        data: {
            action: "request_ajax"
        },
        success: function(data){
            $(".page").html(data);
            create_data();
            handling_new_patrocinador();
        }
      })

    });

    // Delete data
    $(".delete_patrocinador").on("click", function(event){
        event.preventDefault();
        let id  = $(this).data('id')
        let patrocinador = $(this).data('nome')

        Swal.fire({
            title: 'Excluir patrocinador '+patrocinador+'?',
            showDenyButton: true,
            denyButtonColor: '#0275d8',
            confirmButtonColor: '#d9534f',
            confirmButtonText: 'Excluir',
            denyButtonText: `Cancelar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: script_ajax.ajax_url,
                    method: "post",
                    dataType: "html",
                    data: {
                        action: "delete_data",
                        'id':id
                    },
                    success:function(e){
                        location.reload();
                    }
                })
            }
        })
        
        
    });

    // Settings Grupo
    $("#settings_grupo").click(function(event){
        event.preventDefault();

        $.ajax({
            url: script_ajax.ajax_url,
            method: 'post',
            dataType: "html",
            data: {
                action: "settings_grupo"
            },
            success: function(data){
                $(".page").html(data);
                create_grupo()
                delete_grupo()
            }
        })

    });

    // Settings Nivel Patrocinio
    $("#settings_nivel_patrocinio").click(function(event){
        event.preventDefault();

        $.ajax({
            url: script_ajax.ajax_url,
            method: 'post',
            dataType: "html",
            data: {
                action: "settings_nivel_patrocinio"
            },
            success: function(data){
                $(".page").html(data);
                create_nivel_patrocinio();
                delete_nivel_patrocinio();
            }
        })
    });

    // Settings Origem Verba
    $("#settings_origem_verba").click(function(event){
        event.preventDefault();

        $.ajax({
            url: script_ajax.ajax_url,
            method: 'post',
            dataType: "html",
            data: {
                action: "settings_origem_verba"
            },
            success: function(data){
                $(".page").html(data);
                create_origem_verba();
                delete_origem_verba();
            }
        })
    });
})

function handling_new_patrocinador(){
    console.log('Console event')
    jQuery("#projeto").on('blur', function(event){
        if(jQuery(this).val() != '') {
            jQuery("#form_patrocinador").addClass('bg-secondary')
            jQuery("#patrocinador").attr('disabled', true)
            jQuery("#patrocinador").removeAttr('required')
        }else {
            jQuery("#form_patrocinador").removeClass('bg-secondary')
            jQuery("#patrocinador").removeAttr('disabled')
        }
    })
}

function create_data(){
    const $ = jQuery;

    $("#image-upload").change(function(){
        let filename = $(this).val()
        
        if(filename){
            filename = filename.replace(/C:\\fakepath\\/i, '')
            $("#button_logo")
                .removeClass('bg-dark')
                .addClass('bg-success text-white');

            $("#text_logo")
                .text('Imagem selecionada');

            $(".name_logo small")
                .text(filename)
        }
    })

    $("#create_patrocinador").click(async function(event){
        event.preventDefault();
        let patrocinador = $("#patrocinador").val();
        let button = $(this)
        let origem_verba = $("#origem_verba").val();
        let grupo = $("#grupo").val();
        let nivel_patrocinio = $("#nivel_patrocinio").val();
        let projeto = $("#projeto").val();
        let logo = $("#image-upload")[0].files[0];
        let form = new FormData();

        if (projeto) {
            if(logo && checkFileType(logo.type) ){
                form.append('logo', logo)
            }
            form.append('action', 'new_projeto')
            form.append('nome', projeto);
            patrocinador = await new_projeto(form);
            console.log(patrocinador);
        }

        let outroform = new FormData();
        outroform.append('action', 'create_data')
        outroform.append('patrocinador', patrocinador)
        outroform.append('origem_verba', origem_verba)
        outroform.append('grupo', grupo)
        outroform.append('nivel_patrocinio',nivel_patrocinio)
        console.log(patrocinador, origem_verba, grupo, nivel_patrocinio)

        jQuery.ajax({
            url:script_ajax.ajax_url,
            type:"post",
            processData: false, // Don't process the data
            contentType: false, // Don't set contentType
            dataType:"html",
            data: outroform,
            beforeSend: function(){
                button.removeClass('btn-primary').addClass('btn-dark').text('Cadastrando...')
            },
            success: function(e) {
                console.log(e)
                if(e == 1){
                    clear_inputs()
                    button.removeClass('btn-dark').addClass('btn-primary').html('+ <span>Cadastrar patrocinador</span>')
                    trigger_alert()
                } else {
                    alert('Não foi possível concluir cadastro, tente novamente')
                }
            }
        })

    })
}

async function new_projeto(data) {
        
    let projeto = ''
        await jQuery.ajax({
            url:script_ajax.ajax_url,
            type:"post",
            processData: false, // Don't process the data
            contentType: false, // Don't set contentType
            dataType:"html",
            data: data,
            success: function(e) {
                console.log(e)
                projeto = e
            }
        })
    return projeto;

}

function trigger_alert(){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })
      
    return Toast.fire({
        icon: 'success',
        title: 'Cadastrado com sucesso'
    })

}

function clear_inputs(){
    jQuery("#patrocinador").val('');
    jQuery("#origem_verba").val('');
    jQuery("#grupo").val('-1');
    jQuery("#nivel_patrocinio").val('-1');
    jQuery("#image-upload").val('');
    jQuery(".name_logo small")
        .text('Selecione imagem');
    jQuery("#text_logo")
        .text('Enviar Logo');
    jQuery("#button_logo")
        .removeClass('bg-success text-white')
        .addClass('bg-dark');
}

function create_grupo(){
    jQuery("#create_grupo").click(function(event){
        event.preventDefault();
        let input = '<div class="input-group input-group-sm mb-3">'+
        '<input type="text" class="form-control" id="grupo_name" placeholder="Novo Grupo">'+
        '<button class="btn btn-outline-success" type="button" id="insert_grupo">adicionar</button>'+
        '</div>';
      
        jQuery(".group-buttons").html(input)

        jQuery("#insert_grupo").click(function(event){
            event.preventDefault();
            let grupo_name = jQuery('#grupo_name').val();
            if(grupo_name){
                jQuery.ajax({
                    url: script_ajax.ajax_url,
                    method: 'post',
                    dataType: "html",
                    data: {
                        action: "insert_grupo",
                        'nome_grupo': grupo_name
                    },
                    success: function(){
                        location.reload();
                    }
                })
            }
        })
    })
}

function delete_grupo() {
    jQuery(".delete_grupo").click(function(event){
        event.preventDefault();

        let grupo = jQuery(this).data('id');
        let qtd = jQuery(this).data('qtd');
        if(qtd >= 1){
            Swal.fire('Primeiro exclua os patrocinadores que possuem esse grupo ativo. Total de '+qtd+' ativos!!')
            return false;
        }

        if(qtd <= 0) {
            jQuery.ajax({
                url: script_ajax.ajax_url,
                method: "post",
                dataType: "html",
                data: {
                    action: "delete_grupo",
                    'grupo':grupo
                },
                success:function(e){
                    location.reload();
                }
            })
        }
    })
}

function create_nivel_patrocinio(){
    jQuery("#create_nivel_patrocinio").click(function(event){
        event.preventDefault();
        let input = '<div class="input-group input-group-sm mb-3">'+
        '<input type="text" class="form-control" id="nivel_patrocinio_name" placeholder="Novo Nível de Patrocínio">'+
        '<button class="btn btn-outline-success" type="button" id="insert_nivel_patrocinio">adicionar</button>'+
        '</div>';
      
        jQuery(".group-buttons").html(input)

        jQuery("#insert_nivel_patrocinio").click(function(event){
            event.preventDefault();
            let nivel_patrocinio_name = jQuery('#nivel_patrocinio_name').val();
            if(nivel_patrocinio_name){
                jQuery.ajax({
                    url: script_ajax.ajax_url,
                    method: 'post',
                    dataType: "html",
                    data: {
                        action: "insert_nivel_patrocinio",
                        'nivel_patrocinio': nivel_patrocinio_name
                    },
                    success: function(){
                        location.reload();
                    }
                })
            }
        })
    })
}

function create_origem_verba(){
    jQuery("#create_origem_verba").click(function(event){
        event.preventDefault();
        let input = '<div class="input-group input-group-sm mb-3">'+
        '<input type="text" class="form-control" id="origem_verba_name" placeholder="Nome origem da verba">'+
        '<input type="text" class="form-control" id="origem_verba_desc" placeholder="Descricao">'+
        '<button class="btn btn-outline-success" type="button" id="insert_origem_verba">adicionar</button>'+
        '</div>';

        jQuery(".group-buttons").html(input);

        jQuery("#insert_origem_verba").click(function(event){
            event.preventDefault();
            let origem_verba_name = jQuery('#origem_verba_name').val();
            let origem_verba_desc = jQuery('#origem_verba_desc').val();
            if(origem_verba_name){
                jQuery.ajax({
                    url: script_ajax.ajax_url,
                    method: 'post',
                    dataType: "html",
                    data: {
                        action: "insert_origem_verba",
                        'origem_verba_name': origem_verba_name,
                        'origem_verba_desc': origem_verba_desc
                    },
                    success: function(){
                        location.reload();
                    }
                })
            }
        })
    });

    
}

function delete_origem_verba(){
    jQuery(".delete_origem_verba").click(function(event){
        event.preventDefault();
        let origem_verba = jQuery(this).data('id');
        let qtd = jQuery(this).data('qtd');

        if(qtd >= 1){
            Swal.fire('Primeiro exclua os patrocinadores que possuem essa origem de verba ativa. Total de '+qtd+' ativos!!')
            return false;
        }

        if(qtd <= 0) {
            jQuery.ajax({
                url: script_ajax.ajax_url,
                method: "post",
                dataType: "html",
                data: {
                    action: "delete_origem_verba",
                    'origem_verba':origem_verba
                },
                success:function(e){
                    location.reload();
                }
            })
        }
    })
}

function delete_nivel_patrocinio(){
    jQuery(".delete_nivel_patrocinio").click(function(event){
        event.preventDefault();
        let nivel_patrocinio = jQuery(this).data('id');
        let qtd = jQuery(this).data('qtd');

        if(qtd >= 1){
            Swal.fire('Primeiro exclua os patrocinadores que possuem esse nível de patrocínio ativo. Total de '+qtd+' ativos!!')
            return false;
        }

        if(qtd <= 0) {
            jQuery.ajax({
                url: script_ajax.ajax_url,
                method: "post",
                dataType: "html",
                data: {
                    action: "delete_nivel_patrocinio",
                    'nivel_patrocinio':nivel_patrocinio
                },
                success:function(e){
                    location.reload();
                }
            })
        }
    })
}

function checkFileType(extension) {
    let imageExtensions = ["image/jpg", "image/jpeg", "image/png"];
    if (imageExtensions.indexOf(extension) === -1) {
        alert('Formato de imagem não aceito')
        return false;
    }
    return true;
}