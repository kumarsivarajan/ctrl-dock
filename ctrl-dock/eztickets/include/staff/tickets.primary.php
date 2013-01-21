
         <?php 
		  $sel_pri="SELECT * FROM ".TICKET_TABLE ." WHERE ticketID=".$rm['track_id'];
		  $exe_sel_pri=mysql_query($sel_pri);
		  
		  if(mysql_num_rows($exe_sel_pri)==0)
		  {
			  echo "No Primary Tickets Found ..!";
		  }
		  else
		  {
		   
		   while($rr=mysql_fetch_array($exe_sel_pri))
		   {
		  
		 ?> 
           
          <tr>
          <td  align="center" class="light-font">
                    <input type="checkbox" name="tids[]" value="<?=$rr['ticket_id'].','.$rr['track_id'];?>" onClick="highLight(this.value,this.checked);" >
                </td>
           <td  class="light-font">
           <a class="Icon <?=strtolower($rr['source'])?>Ticket" title="<?=$rr['source']?> Ticket: <?=$rr['email']?>" 
           href="tickets.php?id=<?=$rr['ticket_id']?>">
					
					<?php echo $rr['ticketID'];?>
                    </a> 
                    <?php
				  if($rr['ticketID']==$rr['ticketID'])
				  {
					 
					  ?>
                      <span style="background-color:<?php if($rr['track_id']!=0){echo $rr['track_id'];}else{echo "";} ?>;width:10px;color:#FFF;font-family:Arial;font-size:11px;padding:1px">
                      <?php
					  $n="";
					  $k=($rr['track_id']!=0)?$rr['ticket_id']:$n;
					  echo $k;
					  
					  
					  ?>
                      </span>
                      <?php
				  }
					
				 ?>
                 
          
           </td>
           <td class="light-font">
            <?php 
			
			echo $cdate=date('d m Y',strtotime($rr['created']));
			
			?>
          
           </td>
           <td class="light-font" >
           <a <?if($flag) { ?> class="Icon <?=$flag?>Ticket" title="<?=ucfirst($flag)?> Ticket" <?}?> 
                    href="tickets.php?id=<?=$rr['ticket_id']?>&track_id=<?php echo $rr['track_id'];?>">
					<?php echo $rr['subject'];?>
                    </a>
                    &nbsp;<?=$rr['attachments']?"<span class='Icon file'>&nbsp;</span>":''?>
          
           </td>
           <td class="light-font">
            <?php echo $rr['helptopic']?>
          
           </td>
           <?php 
			$sel_pricolor="SELECT * FROM isost_ticket_priority WHERE priority_id =".$rr['priority_id'];
			$exe_pricolor=mysql_query($sel_pricolor);
			
			while($col=mysql_fetch_array($exe_pricolor))
			{
				?>
                <td class="light-font" bgcolor="<?php echo $col['priority_color'];?>" align="center">
            
                 <?php echo $col['priority_desc'];?>
                </td>
                <?php 
			}
			?>
           
           <td class="light-font">
            <?php echo $rr['name']?>
          
           </td>
           <td class="light-font">
            <?php echo $rr['subject']?>
          
           </td>
           
          </tr>
        <?php
		   }
		  }
		?>
				 
	    

 
