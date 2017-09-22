<?php
	$html = (file_exists( $tpl )) ? file_get_contents( $tpl ) : 'Template File Missing';
    
    // Header
	$page_title .= '&gt;&gt; ' . $page;
    $header = displayHeader();
	$navigation = $nav->displayNav();
	
	if ($session->userdata['userlevel'] > 5)
	{
		$css .= '@import url(' . $fs['css'] . 'admin.css);';
	}
	
	
	// Right bar
	require_once( $fs_root . 'inc/classes/Programme.php' );
    $upcoming = new Programme;
    $prog = $upcoming->listProgrammeSummary( 'upcoming' );
   
    
    // Footer
    $copy_date = (date('Y') == 2008) ? '2008' : '2008 - ' . date('Y');
    
    
    // Body
    $replace = array(
		'%BODY%'             => $body,
        '%FS_ROOT%'          => $fs_root,
        '%FS_CSS%'           => $fs['css'], 
        '%FS_JS%'            => $fs['js'],
        '%FS_IMG%'           => $fs['img'],
        '%PAGE_TITLE%'       => $page_title, 
        '%CSS%'              => $css, 
        '%EXTRA_HEAD_INFO%'  => $extra_head_info,
        '%HEADER%'			 => $header,
        '%NAVIGATION%'       => $navigation,
        '%PROCESS_TEXT%'     => $user->login_text,
        '%RIGHT_CONTENT%'    => $right_content,
        '%PROG%'             => $prog,
        '%USER_LINKS%'       => $user_links,
        '%COPY_DATE%'        => $copy_date,
        '%GALLERY%'          => $gallery,
        '%SEPARATOR%'        => $separator,
        '%GALL_LINK%'        => $gall_link,
        '%IFRAME%'           => $iframe,
        '%MCE%'              => $mce,
        '%FS_ADMIN_NEWS%'    => $fs['admin_news'],
        '%FS_ADMIN_CONTENT%' => $fs['admin_content'],
        '%FS_ADMIN_MENU%'    => $fs['admin_menu'],
        '%FS_ADMIN_PROG%'    => $fs['admin_prog'],
        '%FS_ADMIN_USERS%'   => $fs['admin_users'],
        '%FS_ADMIN_DL%'      => $fs['admin_dl'],
        '%FS_ADMIN_DIARIES%' => $fs['admin_diaries'],
        '%FS_ADMIN_LINKS%'    => $fs['admin_links']);
	$html = @str_replace( array_keys($replace), array_values($replace), $html );
	
?>