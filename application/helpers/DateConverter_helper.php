<?php
function ConvertToSql($date)
{
	return date('Y-m-d',strtotime($date));
}