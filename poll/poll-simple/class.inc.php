<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajax Poll Script v3.02 [ GPL ]
// Copyright (c) phpkobo.com ( http://www.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : APSMX-302
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTClass extends CTClassBase
{
	function setupPoll( $poll ) {

		//-- Poll Title
		$poll->attr( "title", "Apakah pendapat anda tentang sistem eLATS?" );

		//-- Poll Options
		$poll->addItem( "Mudah digunakan, difahami dan tidak rumit" );
		$poll->addItem( "Warna dan susun atur modul teratur dan menarik" );
		$poll->addItem( "Mudah, pantas dan sistematik" );
		$poll->addItem( "Rekod kursus saya dapat dicetak terus dan dapat mengelak data kursus saya dari hilang" );   
		$poll->addItem( "Kursus saya dapat dikemaskini dan dipantau oleh penyelia saya" );
		$poll->addItem( "Secara keseluruhannya, saya berpendapat sistem eLATS ini sangat baik dan efisen" );     

		//-- Text used in polls
		$poll->attr( "msg-vote", "Hantar Pilihan" );
		$poll->attr( "msg-select-one", "Sila pilih satu pilihan" );
		$poll->attr( "msg-already-voted", "Anda telah memilih!" );
		$poll->attr( "msg-view-result", "Keputusan" );
		$poll->attr( "msg-thank-you", "Terima kasih atas maklumbalas anda!" );
		$poll->attr( "msg-return", "Back" );
		$poll->attr( "msg-total", "Jumlah" );
		$poll->attr( "msg-reset-block", "Reset IP & Cookie Block" );
		$poll->attr( "msg-not-started", "Voting has not begun yet." );
		$poll->attr( "msg-ended", "Voting has ended, thank you!" );

		//-- Display "Reset IP & Cookie Block" button
		//--	Show: true
		//--	Hide: false
		$poll->attr( "b-reset-block", false );

		//-- Single selection or multiple selection
		//--	single selection: "radio"
		//--	multiple selection: "checkbox"
		$poll->attr( "vote-input", "radio" );

		//-- Specify the time delay on tool tips in milliseconds
		$poll->attr( "tip-box-duration", 2000 );

		//-- Prevent users from voting more than once by IP address
		//--	"true" or "false"
		$poll->attr( "enable-ip-block", false );

		//-- Prevent users from voting more than once by Cookie
		//--	"true" or "false"
		$poll->attr( "enable-cookie-block", false );

		//-- Specifiy the cookie's life span in seconds
		//--	(e.g.)　60*60*24 => One Day
		//--	(e.g.)　60*60*24*365 => One Year
		$poll->attr( "cookie-block-period", 60*60*24*365 );

		//-- Specifiy Start and End Date&Time:
		//-- Enter an empty string ("") if you don't need to specify it.
		//--	(e.g.)　"2010-01-02"
		//--	(e.g.)　"2015-03-01 15:20"
		$poll->attr( "dt-start", "" );
		$poll->attr( "dt-end", "" );

		//-- end
		return true;
	}
}

?>
