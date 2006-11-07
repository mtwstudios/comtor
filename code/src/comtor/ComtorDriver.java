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
  * $Id: ComtorDriver.java,v 1.5 2006-11-07 04:33:38 brigand2 Exp $
  **************************************************************************/

import com.sun.javadoc.*;
import java.util.*;

/**
 * The <code>ComtorDriver</code> class is a tool to
 * run doclets and return a property list.
 *
 * @author Joe Brigandi
 */
public final class ComtorDriver
{ 
  public static boolean start(RootDoc rootDoc)
  {        
    Vector v = new Vector();
    
    CheckForTags cft = new CheckForTags(); 
    Properties cftList = cft.analyze(rootDoc); 
    v.addElement(cftList);
    
    CommentAvgRatio car = new CommentAvgRatio();
    Properties carList = car.analyze(rootDoc);
    v.addElement(carList);
    
    GenerateReport report = new GenerateReport();
    report.generateReport(v);
    
    return true;
  }
}