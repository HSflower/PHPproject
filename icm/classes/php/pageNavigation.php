<div class="pageNumber">
	<? 
	if( $obj->isPrevBlock()) 
	{
		echo '<a href="#" ><img class="jPage" page="1" src="/admin/inc/images/paging_first.gif" alt="처음페이지"></a>';
		echo '<a href="#" ><img class="jPage" page="' . ($obj->startBlock - 1) . '" src="/admin/inc/images/paging_prev.gif" alt="이전"></a>';
	}

	for($i = $obj->startBlock ; $i <= $obj->endBlock  ; $i++ )
	{ 			
		if( $obj->req["page"] == $i ) 
			echo '<a href="#" ><strong>'.$i.'</strong></a>' ;
		else
			echo '<a href="#" class="jPage" page="'.$i.'">'.$i.'</a>' ;
	}

	if( $obj->isNextBlock())
	{
		echo '<a href="#" ><img class="jPage" page="' . ($obj->endBlock + 1) . '" src="/admin/inc/images/paging_next.gif" alt="다음"></a>';
		echo '<a href="#" ><img class="jPage" page="' . ($obj->endPage) . '" src="/admin/inc/images/paging_last.gif" alt="마지막페이지"></a>';
	}
	?>
</div>
