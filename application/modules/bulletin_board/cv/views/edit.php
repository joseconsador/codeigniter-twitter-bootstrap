<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="message-div"></div>
<form action="" method="post" class="require-validation" enctype="multipart/form-data">
<ul class="board_detail">
    <li>
        <dl>
            <dt>Writer</dt>
            <dd>
                <input type="text" name="writer" class="required" value="<?php echo isset($writer) ? $writer : '';?>" maxlength="15"/>
                <?php echo form_error('writer');?>
            </dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Subject</dt>
            <dd>
                <input type="text" name="subject" value="<?php echo isset($subject) ? $subject : '';?>"  class="required"/>
                <?php echo form_error('subject');?>
            </dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>Message</dt>
            <dd class="message">
                <?php echo form_error('message');?>
                <textarea name="message" class="required" rows="8" cols="40" ><?php echo isset($message) ? $message : '';?></textarea>
            </dd>
        </dl>
    </li>
    <li>
        <dl>
            <dt>File</dt>
            <dd>
                <input type="file" name="filename" />
                <input type="hidden" name="field_filename" value="filename" />
                <?php echo isset($old_file) ? anchor (site_url('download/index/' . $old_file), 'Download attachment') : '';?>
                <?php echo form_error('field_filename');?>
            </dd>
        </dl>
    </li>
    <li class="submit">
        <input type="submit" name="submit" value="Submit"/>
        <input type="button" name="cancel" value="Cancel"/>
    </li>
</ul>

<?php if (isset($index)):?>
    <input type="hidden" name="index" value="<?php echo $index;?>" />
<?php endif;?>
</form>
