<?php

class DateTimeUtilities{

  public static function addMonths($date,$months){

         $init=clone $date;
         $modifier=$months.' months';
         $back_modifier =-$months.' months';

         $date->modify($modifier);
         $back_to_init= clone $date;
         $back_to_init->modify($back_modifier);

         while($init->format('m')!=$back_to_init->format('m')){
         $date->modify('-1 day')    ;
         $back_to_init= clone $date;
         $back_to_init->modify($back_modifier);
         }

         /*
         if($months<0&&$date->format('m')>$init->format('m'))
         while($date->format('m')-12-$init->format('m')!=$months%12)
         $date->modify('-1 day');
         else
         if($months>0&&$date->format('m')<$init->format('m'))
         while($date->format('m')+12-$init->format('m')!=$months%12)
         $date->modify('-1 day');
         else
         while($date->format('m')-$init->format('m')!=$months%12)
         $date->modify('-1 day');
         */

     }

     public static function addYears($date,$years){

         $init= new DateTime($date);
         $modifier=$years.' years';
         $date->modify($modifier);
         $date = new DateTime($date);

         while($date->format('m')!=$init->format('m'))
         $date->modify('-1 day');


     }


   }

   ?>
