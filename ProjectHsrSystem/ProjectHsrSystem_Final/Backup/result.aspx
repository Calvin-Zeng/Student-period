<%@ Page Language="vb" AutoEventWireup="false" CodeBehind="result.aspx.vb" Inherits="ProjectHsrSystem_Final.result" %>

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
    <table style="width:80%;margin-left:auto; margin-right:auto;" >
        <tr>
            <td>
                    <asp:Label ID="Label2" runat="server"></asp:Label>
                    <asp:Label ID="Label3" runat="server"></asp:Label>
                </td>
        </tr>
        <tr>
            <td>
                                <asp:GridView ID="GridView1" runat="server" AutoGenerateColumns="False" 
                                    style="text-align: center" Width="439px">
                                    <Columns>
                                        <asp:HyperLinkField DataNavigateUrlFields="車次" 
                                            DataNavigateUrlFormatString="traindetails.aspx?station={0}" HeaderText="今日行駛" 
                                            Text="[詳細]" Target="_blank" />
                                        <asp:BoundField DataField="車次" HeaderText="車次" SortExpression="車次" />
                                        <asp:BoundField DataField="發車時間" HeaderText="發車時間" SortExpression="發車時間" />
                                        <asp:BoundField DataField="暫存" HeaderText="搭乘時間" SortExpression="暫存" />
                                        <asp:BoundField DataField="抵達時間" HeaderText="抵達時間" SortExpression="抵達時間" />
                                        <asp:ButtonField CommandName="book" HeaderText="訂票" Text="[訂票]" />
                                    </Columns>
                                </asp:GridView>
                            </td>
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