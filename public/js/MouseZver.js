$(function ( menu, num_menu, i, MOUSE_CURSOR, REG_STEP_FLAG )
{
	function EngineMenuClose()
	{
		$( '#ACCOUNT-MENU' ).animate({ left: -288 });
		
		setTimeout( function ()
		{
			$( '#ACCOUNT-MENU' ).empty();
			
			menu = false;
		}, 500 );
	}
	
	if ( menu )
	{
		$( document ).mousedown( function ( e )
		{
			EngineMenuClose();
		});
		
	}
	
	$( 'body' ).on( 'mouseenter', '#ENGINE-USER-MENU', function ()
	{
		if ( menu && num_menu != 'USER' )
		{
			EngineMenuClose();
		}
		
		MOUSE_CURSOR = true;
		
		setTimeout( function ()
		{
			if ( menu !== true && MOUSE_CURSOR )
			{
				menu = true;
				
				num_menu = 'USER';
				
				$( '#ACCOUNT-MENU' ).append( 
					'<div class="U-MENU-PRIMARY">' +
					'<a class="AVATAR" href="#"><img src="/public/test/img.jpg"></a>' +
					'<h3><a href="/u/MouseZver" title="Посмотреть Ваш профиль">MouseZver</a></h3>' +
					'<div>Активный пользователь</div>' +
					'<h4><a href="/u/MouseZver">Страница профиля</a></h4>' +
					'</div>'
				)
				
				$( '#ACCOUNT-MENU' ).animate({ left: 10 });
				
			}
		}, 1000 );
	})
	.on( 'mouseenter', '#ENGINE-NOTICE-MENU', function ()
	{
		if ( menu && num_menu != 'NOTICE' )
		{
			EngineMenuClose();
		}
		
		MOUSE_CURSOR = true;
		
		setTimeout( function ()
		{
			if ( menu !== true && MOUSE_CURSOR )
			{
				menu = true;
				
				num_menu = 'NOTICE';
				
				$( '#ACCOUNT-MENU' ).append( 
					'<div class="U-MENU-PRIMARY">' +
					'<div class="LIST-NOTICES">Капуста</div>' +
					'</div>'
				)
				
				$( '#ACCOUNT-MENU' ).animate({ left: 10 });
				
			}
		}, 1000 );
	})
	.on( 'mouseleave', '#ENGINE-USER-MENU, #ENGINE-NOTICE-MENU', function()
	{
		MOUSE_CURSOR = false;
	})
	
	// form 
	.on( 'submit', 'form', function ( e )
	{
		e.preventDefault();
		
		var obj = new FormData( $( this ).get(0) );
		
		$.ajax(
		{
			url: $( this ).attr( 'action' ),
			type: $( this ).attr( 'method' ),
			contentType: false,
			processData: false,
			data: obj,
			dataType: 'JSON',
			success: function ( json )
			{
				
				if ( json.ELEMENTS.REDIRECT != undefined )
				{
					window.location.href = json.ELEMENTS.REDIRECT;
				}
				if ( json.ELEMENTS.MSGERROR != undefined )
				{
					$( '.errorPanel' ).remove();
					
					$( '.RAY_WRAPPER_REGISTER' ).prepend( '<div class="errorPanel"></div>' );
					
					i = 1;
					
					$.each( json.ELEMENTS.MSGERROR, function ( index, value )
					{
						$( '.errorPanel' ).append( '<p>' + i++ + ') ' + value + '</p>' );
					});
				}
			}
		});
	})
	.on( 'click', '#CAPTCHA', function ()
	{
		if ( REG_STEP_FLAG )
		{			
			$( '.REGISTER-TWO-STEP' ).removeClass( 'REGISTER-VISIBLE' );
			$( '.REGISTER-ONE-STEP' ).addClass( 'REGISTER-VISIBLE' );
			
			REG_STEP_FLAG = false;
		}
		else
		{
			$( '.REGISTER-ONE-STEP' ).removeClass( 'REGISTER-VISIBLE' );
			$( '.REGISTER-TWO-STEP' ).addClass( 'REGISTER-VISIBLE' );
			
			REG_STEP_FLAG = true;
		}	
	})
});