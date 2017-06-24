<?php
!defined('MIINC') && exit("403 Forbidden!");
/**
 * 
 *
 * @version        $Id: productimagelist.lib.php
 * @package        Mi.Taglib
 * @copyright      Copyright (c)  2010, Missra
 * @license        http://help.missra.com/usersguide/license.html
 * @link           http://www.missra.com
 */
 
function lib_productimagelist(&$ctag, &$refObj)
{
    global $dsql,$sqlCt;
    $attlist="desclen|80";
    FillAttsDefault($ctag->CAttribute->Items,$attlist);
    extract($ctag->CAttribute->Items, EXTR_SKIP);

    if(!isset($refObj->addTableRow['imgurls'])) return ;
    
    $revalue = '';
    $innerText = trim($ctag->GetInnerText());
    if(empty($innerText)) $innerText = GetSysTemplets('productimagelist.htm');
    
    $dtp = new MiTagParse();
    $dtp->LoadSource($refObj->addTableRow['imgurls']);
    
    $images = array();
    if(is_array($dtp->CTags))
    {
        foreach($dtp->CTags as $ctag)
        {
            if($ctag->GetName()=="img")
            {
                $row = array();
                $row['imgsrc'] = trim($ctag->GetInnerText());
                $row['text'] = $ctag->GetAtt('text');
                $images[] = $row;
            }
        }
    }
    $dtp->Clear();

    $revalue = '';
    $ctp = new MiTagParse();
    $ctp->SetNameSpace('field','[',']');
    $ctp->LoadSource($innerText);

    foreach($images as $row)
    {
        foreach($ctp->CTags as $tagid=>$ctag)
        {
            if(isset($row[$ctag->GetName()])){ $ctp->Assign($tagid,$row[$ctag->GetName()]); }
        }
        $revalue .= $ctp->GetResult();
    }
    return $revalue;
}