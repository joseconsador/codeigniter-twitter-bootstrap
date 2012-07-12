<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul class="board_detail">
    <li>
        <dl>
            <dt>Writer</dt>
            <dd><?php echo $writer;?></dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Subject</dt>
            <dd><?php echo $subject;?></dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt> Message </dt>
            <dd class="message"><?php echo $message;?></dd>
        </dl>
    </li>
    <?php if (isset($filename) && trim($filename) != ''):?>
    <li>
        <dl>
            <dt>File</dt>
            <dd><?php echo anchor (site_url('download/index/' . $filename), 'Download attachment');?></dd>
        </dl>
    </li>
    <?php endif;?>
    <li class="submit">
        <input type="button" name="cancel" value="List"/>
        <input type="button" name="modify" value="Modify" jmchref="<?php echo site_url('bbc/post/edit/' . $index);?>"/>
    </li>
</ul>
<input type="hidden" name="index" value="<?php echo $index;?>" />