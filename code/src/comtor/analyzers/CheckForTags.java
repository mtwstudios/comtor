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
  *  Free Software Foundation, Inc.
  *  59 Temple Place, Suite 330 
  *  Boston, MA  02111-1307  USA
  *
  * $Id: CheckForTags.java,v 1.12 2006/11/15 06:19:41 brigand2 Exp $
  **************************************************************************/
package comtor.analyzers;

import comtor.*;
import com.sun.javadoc.*;
import java.util.*;
import java.text.*;

/**
 * The <code>CheckForTags</code> class is a tool to check
 * for JavaDocs with returns, throw, and param tags.
 *
 * @author Joe Brigandi
 */
public class CheckForTags implements ComtorDoclet
{ 
  Properties prop = new Properties();
  
  /**
   * Examine each class, obtain each method. Check for
   * returns tag. Check for throw tag. Check for param tags.
   *
   * @param rootDoc  the root of the documentation tree
   * @returns Properties list
   */
  public Properties analyze(RootDoc rootDoc)
  {
    prop.setProperty("title", "Check For Tags");
    prop.setProperty("description", "Checks for the proper use of return, throw, and param tags.");
    
    ClassDoc[] classes = rootDoc.classes();
    
    for(int i=0; i < classes.length; i++)
    {
      String classID = numberFormat(i);
      prop.setProperty("" + classID, "Class: " + classes[i].name());
      MethodDoc[] methods = new MethodDoc[0];
      methods = classes[i].methods();
      
      for(int j=0; j < methods.length; j++)
      {
        String methodID = numberFormat(j);
        prop.setProperty(classID + "." + methodID, "Method: " + methods[j].name());
        
/////////////////return tags/////////////////
        String returnParam = "@return";
        Tag[] returnTags = methods[j].tags(returnParam);
        String returntype = methods[j].returnType().typeName();
        
        if(returntype=="void")
        {
          if(returnTags.length==0)
            prop.setProperty(classID + "." + methodID + ".b", "Analyzed method " + methods[j].name() + "'s declared return type and <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag. The declared return type is void and there is no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag present in the comments.");
          else
            prop.setProperty(classID + "." + methodID + ".b", "Analyzed method " + methods[j].name() + "'s declared return type and <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag. The declared return type is void but an <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag is present in the comments. There should be no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag since the declared return type is void.");
        }
        else
        {
          if(returnTags.length==1)
            prop.setProperty(classID + "." + methodID + ".b", "Analyzed method " + methods[j].name() + "'s declared return type and <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag. The declared return type is " + returntype + " and there is an <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag present in the comments.");
          else if(returnTags.length==0) 
            prop.setProperty(classID + "." + methodID + ".b", "Analyzed method " + methods[j].name() + "'s declared return type and <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag. The declared return type is " + returntype + " but there is no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag present in the comments.");
          else if(returnTags.length > 1)
            prop.setProperty(classID + "." + methodID + ".b", "Analyzed method " + methods[j].name() + "'s declared return type and <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag. The declared return type is " + returntype + " but there is " + returnTags.length + " <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tags present in the comments.  There should only be one <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@return</a> tag.");
        }
        
/////////////////param tags/////////////////
        String param = "@param";
        Parameter[] parameter = new Parameter[0];
        parameter = methods[j].parameters();
        Tag[] paramTags = methods[j].tags(param);
        int paramCount=0;
        
        for(int s=0; s < parameter.length; s++)
        { 
          boolean check = false;
          for(int q=0; q < paramTags.length; q++) 
          {
            if(paramTags[q].text().startsWith(parameter[s].name()))
              check = true;
            if(check)
            {
              String count = numberFormat(paramCount);
              prop.setProperty(classID + "." + methodID + ".c" + count, "Analyzed method " + methods[j].name() + "'s parameter " + parameter[s].typeName() + " " + parameter[s].name() + ". The paramter and paramter type match the <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag in the comments.");
              paramCount++;
              break;
            }
          }
          if(!check)
          {
            String count = numberFormat(paramCount);
            prop.setProperty(classID + "." + methodID + ".c" + count, "Analyzed method " + methods[j].name() + "'s parameter " + parameter[s].typeName() + " " + parameter[s].name() + ". There is no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag present for this paramter.");
            paramCount++;
          }
        }
        
        for(int s=0; s < paramTags.length; s++)
        {
          boolean check = false;
          for(int q=0; q < parameter.length; q++)
          {
            if(paramTags[s].text().startsWith(parameter[q].name()))
              check = true;
          }
          if(!check)
          {
            String count = numberFormat(paramCount);
            prop.setProperty(classID + "." + methodID + ".c" + count, "Analyzed method " + methods[j].name() + "'s <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag " + paramTags[s].text() + ". There is no parameter in the method for the this <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag.");
            paramCount++;
          }
        }
        
/////////////////throws tags/////////////////
        String throwParam = "@throws";
        Tag[] throwsTags = methods[j].tags(throwParam);
        ClassDoc[] exceptions = methods[j].thrownExceptions();
        int throwsCount=0;
        
        for(int s=0; s < exceptions.length; s++)
        {
          boolean check = false;
          for(int q=0; q < throwsTags.length; q++)
          {
            if(throwsTags[q].text().startsWith(exceptions[s].name()))
              check = true;
            if(check)
            {
              String num = numberFormat(throwsCount);
              prop.setProperty(classID + "." + methodID + ".d" + num, "Analyzed method " + methods[j].name() + "'s exception " + exceptions[s].name() + ". The exception matches the <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@throws</a> tag in the comments.");
              throwsCount++;
              break;
            }
          }
          if(!check)
          {
            String num = numberFormat(throwsCount);
            prop.setProperty(classID + "." + methodID + ".d" + num, "Analyzed method " + methods[j].name() + "'s exception " + exceptions[s].name() + ". There is no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@throws</a> tag present for this exception.");
            throwsCount++;
          }
        }
        
        for(int s=0; s < throwsTags.length; s++)
        {
          boolean check = false;
          for(int q=0; q < exceptions.length; q++)
          {
            if(throwsTags[s].text().startsWith(exceptions[q].name()))
              check = true;
          }
          if(!check)
          {
            String num = numberFormat(throwsCount);
            prop.setProperty(classID + "." + methodID + ".d" + num, "Analyzed method " + methods[j].name() + "'s <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@throws</a> tag " + throwsTags[s].text() + ". There is no exception in the method for this <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@throws</a> tag.");
            throwsCount++;
          }
        }
      }
      
      ConstructorDoc[] constructors = new ConstructorDoc[0];
      constructors = classes[i].constructors();   
      for(int j=0; j < constructors.length; j++)
      {
        String methodID = numberFormat(j);
        
        String param = "@param";
        Parameter[] parameter = new Parameter[0];
        parameter = constructors[j].parameters();
        Tag[] paramTags = constructors[j].tags(param);
        int paramCount=0;
        
        for(int s=0; s < parameter.length; s++)
        { 
          boolean check = false;
          for(int q=0; q < paramTags.length; q++) 
          {
            if(paramTags[q].text().startsWith(parameter[s].name()))
              check = true;
            if(check)
            {
              String count = numberFormat(paramCount);
              prop.setProperty(classID + "." + methodID + ".a" + count, "Analyzed constructor's parameter " + parameter[s].typeName() + " " + parameter[s].name() + ". The paramter and paramter type match the <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag in the comments.");
              paramCount++;
              break;
            }
          }
          if(!check)
          {
            String count = numberFormat(paramCount);
            prop.setProperty(classID + "." + methodID + ".a" + count, "Analyzed constructor's parameter " + parameter[s].typeName() + " " + parameter[s].name() + ". There is no <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag present for this paramter.");
            paramCount++;
          }
        }
        
        for(int s=0; s < paramTags.length; s++)
        {
          boolean check = false;
          for(int q=0; q < parameter.length; q++)
          {
            if(paramTags[s].text().startsWith(parameter[q].name()))
              check = true;
          }
          if(!check)
          {
            String count = numberFormat(paramCount);
            prop.setProperty(classID + "." + methodID + ".a" + count, "Analyzed constructor's <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag " + paramTags[s].text() + ". There is no parameter in the method for the this <a href=\"http://java.sun.com/j2se/1.3/docs/tooldocs/win32/javadoc.html#javadoctags\">@param</a> tag.");
            paramCount++;
          }
        }  
      }
    }    
    return prop;
  }
  
  private String numberFormat(int value)
  {
    String newValue;
    if(value<10)
      newValue = "00" + value;
    else if(value<100)
      newValue = "0" + value;
    else
      newValue = "" + value;
    
    return newValue;
  }
}