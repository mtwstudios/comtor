/***************************************************************************
 *  Comment Mentor: A Comment Quality Assessment Tool
 *  Copyright (C) 2005 Michael E. Locasto
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful, but
 *  WITHOUT ANY WARRANTY; without even the implied warranty of 
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU 
 *  General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the:
 *	 Free Software Foundation, Inc.
 *	 59 Temple Place, Suite 330 
 *	 Boston, MA  02111-1307  USA
 *
 * $Id: PercentageMethods.java,v 1.1 2006-07-17 15:33:10 locasto Exp $
 **************************************************************************/
package comtor;


import com.sun.javadoc.*;

/**
 * The <code>PercentageMethods</code> class is a tool to
 * measure a the percentage of methods in a class that are
 * documented with a JavaDoc header.
 *
 * @author Michael Locasto
 */
public final class PercentageMethods
{


   /**
    * Entry point. XXX change implementation
    *
    * @param rootDoc  the root of the documentation tree
    * @returns some boolean value
    */
   public static boolean start(RootDoc rootDoc)
   {
      long commentLengthSum = 0L;
      long avgCommentLength = 0L;
      long commentLength = 0L;
      ClassDoc[] classes = rootDoc.classes();
      MethodDoc[] methods = new MethodDoc[0];
      for(int i=0;i<classes.length;i++)
      {
         avgCommentLength = 0L;
         commentLengthSum = 0L;
         commentLength = 0L;
         methods = classes[i].methods();
         for(int j=0;j<methods.length;j++)
         {
            commentLength = methods[j].getRawCommentText().length();
            commentLengthSum+=commentLength;
            System.out.println("method: "+methods[j].name()
                               +" ("+commentLength+" chars)");
         }
         if(0!=methods.length)
            avgCommentLength = (commentLengthSum/methods.length);
         else
            avgCommentLength = 0;
         System.out.println(classes[i]+": "+avgCommentLength+" characters.");
      }
      return true;
   }
}
