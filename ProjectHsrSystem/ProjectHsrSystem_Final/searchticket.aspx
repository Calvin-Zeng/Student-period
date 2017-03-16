<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="searchticket.aspx.vb" Inherits="ProjectHsrSystem_Final.searchticket" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>高鐵查/訂票系統</title>
<link rel=stylesheet type="text/css" href="layout.css">
</head>

<body>
<div id="wrapper">
<div id="header">
  <h1>高鐵查/訂票系統</h1>
</div>
<div id="siderbar">
<div id="siderbar_content">
  <p><a href="default.aspx"><img src="images/home.png" width="170" height="57" alt="首頁" /></a></p>
  <p><a href="searchticket.aspx"><img src="images/book.png" width="170" height="57" alt="查/訂票" /></a></p>
  <p><a href="login.aspx"><img src="images/detail.png" width="170" height="52" alt="查詢訂票紀錄"/></a></p>
  <ul>
    <li><a href="login.aspx"><img src="images/cancel.png" width="170" height="57" alt="取消訂票"/></a></li>
  </ul>
  <p><a href="manual.aspx"><img src="images/manual.png" width="170" height="57" alt="使用說明" /></a></p>
  <p><a href="about.aspx"><img src="images/about.png" width="170" height="57" alt="關於我們"/></a></p>
  <p>&nbsp;</p>
</div>

</div>
<div id="content">
  <div id="content_u"></div>
        <div id="content_m">
            <form id="form1" runat="server">
    <table style="width:70%;margin-left:auto; margin-right:auto;" >
        <tr>
            <td>
                &nbsp;</td>
            <td>
                <asp:Button ID="Button1" runat="server" Text="起迄站互換" CssClass="b1" />
                <asp:Button ID="Button2" runat="server" Text="現在時間" CssClass="b1" />
                <asp:Button ID="Button5" runat="server" CssClass="b1" Text="重新訂票" />
            </td>
        </tr>
        <tr>
            <td>
                起訖站
           
            </td>
            <td>
                起站：<asp:DropDownList ID="DropDownList1" runat="server" 
                        DataSourceID="StartSource" DataTextField="station_name" 
                        DataValueField="station_name">
                </asp:DropDownList>
                到達：<asp:DropDownList ID="DropDownList2" runat="server" 
                        DataSourceID="StartSource" DataTextField="station_name" 
                        DataValueField="station_name">
                </asp:DropDownList><asp:SqlDataSource ID="StartSource" runat="server" 
                        ConnectionString="<%$ ConnectionStrings:TrainsConnectionString %>" 
                        SelectCommand="SELECT [station_name] FROM [stations]"></asp:SqlDataSource>
            </td>
        </tr>
        <tr>
            <td>
                時間</td>
            <td>
                <asp:Button ID="Button4" runat="server" Text="選擇日期" CssClass="b1" />
                    <asp:DropDownList ID="DropDownList3" runat="server" style="text-align: center">
                        <asp:ListItem>01:00</asp:ListItem>
                        <asp:ListItem>02:00</asp:ListItem>
                        <asp:ListItem>03:00</asp:ListItem>
                        <asp:ListItem>04:00</asp:ListItem>
                        <asp:ListItem>05:00</asp:ListItem>
                        <asp:ListItem>06:00</asp:ListItem>
                        <asp:ListItem>07:00</asp:ListItem>
                        <asp:ListItem>08:00</asp:ListItem>
                        <asp:ListItem>09:00</asp:ListItem>
                        <asp:ListItem>10:00</asp:ListItem>
                        <asp:ListItem>11:00</asp:ListItem>
                        <asp:ListItem>12:00</asp:ListItem>
                        <asp:ListItem>13:00</asp:ListItem>
                        <asp:ListItem>14:00</asp:ListItem>
                        <asp:ListItem>15:00</asp:ListItem>
                        <asp:ListItem>16:00</asp:ListItem>
                        <asp:ListItem>17:00</asp:ListItem>
                        <asp:ListItem>18:00</asp:ListItem>
                        <asp:ListItem>19:00</asp:ListItem>
                        <asp:ListItem>20:00</asp:ListItem>
                        <asp:ListItem>21:00</asp:ListItem>
                        <asp:ListItem>22:00</asp:ListItem>
                        <asp:ListItem>23:00</asp:ListItem>
                        <asp:ListItem>00:00</asp:ListItem>
                    </asp:DropDownList></td>
        </tr>
        <tr>
            <td >
                </td>
            <td >
                <asp:Calendar ID="Calendar1" runat="server" style="padding:!important;" ></asp:Calendar></td>
        </tr>
        <tr>
            <td>
                &nbsp;</td>
            <td>
                <asp:Button ID="Button3" runat="server" Text="查詢時刻表" CssClass="b1" /><asp:Label ID="Label1" runat="server"></asp:Label></td>
        </tr>
    </table>
            </form>
  </div>
<div id="content_d"></div>
  
</div>
<div id="footer">高鐵查/訂票系統 版權所有 明新科技大學-蔡旻晃/陳致翰/曾啟倫 版面樣式：曾啟倫</div>
</div>

</body>
</html>