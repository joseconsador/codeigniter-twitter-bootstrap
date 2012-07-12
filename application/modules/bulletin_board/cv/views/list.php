<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="search">
    <form action="<?php echo site_url('bbc/post/search');?>" method="get">
        <select name="key">
            <option value="subject">subject</option>
            <option value="message">message</option>
        </select>
        <input type="text" name="value"/>
        <input type="submit" value="Search"/>
    </form>
</div>
<?php if (isset($posts) && count($posts) > 0):?>
<form action="" method="post" />
<table class="board_list">
    <caption>Today: <?php echo $today;?>  / Total: <?php echo $total;?></caption>
    <thead>
        <tr>
            <th>No</th>
            <th>Subject</th>
            <th>Writer</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($posts as $post):?>
        <tr>
            <td><?php echo $post->index;?></td><!--post index. retrieved from db-->
            <td class="subject">
                <input type="checkbox" name="index[]" value="<?php echo $post->index;?>" title="" />
                <?php echo anchor('bbc/post/view/' . $post->index, $post->subject);?>
            </td><!--subject or post title. retrieved from db-->
            <td><?php echo $post->writer;?></td><!--writer's name. retrieved from db-->
            <td><?php echo $post->registerTime;?></td><!--written date. retrieved from db. Timestamp in DB. display format:dd/mm/yyyy-->
            <td>
                <?php echo anchor('bbc/post/edit/' . $post->index, 'Edit');?>
                <?php echo anchor('bbc/post/delete/' . $post->index, 'delete', 'class="delete"');?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<div style="clear:both">
    <ul class="pagination right">
        <?php echo $this->pagination->create_links(); ?>
    </ul>
</div>
<div><input type="submit" name="submit" value="Delete"/></div>
<?php ;else:?>
<div>No posts found.</div>
<?php endif;?>
<div><?php echo anchor('bbc/post/add', 'Write');?></div>