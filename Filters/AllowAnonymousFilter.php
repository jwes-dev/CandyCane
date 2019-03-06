<?php
class AllowAnonymousFilter extends Filter
{
    public function OnBeforeExecute()
    {
        return -1;
    }
}
?>