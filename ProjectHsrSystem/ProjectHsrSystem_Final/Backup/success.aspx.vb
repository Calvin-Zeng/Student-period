Public Class success
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load


        Dim sds As New SqlDataSource
        Dim sqlstr As String
        sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        sqlstr = "SELECT orderinfo.ordertime as 時間與日期, orderinfo.train_id as 車次, orderinfo.start_station as 起站, orderinfo.end_station as 到達, ticketprinum.fcount as 全票數,ticketprinum.ccount as 孩童票數,ticketprinum.ocount as 敬老票數,ticketprinum.lcount as 愛心票數, orderinfo.code as 交易代碼 FROM orderinfo,ticketprinum WHERE orderinfo.code = ticketprinum.code AND ticketprinum.code LIKE '" & Session("code") & "%%" & "'"
        sds.SelectCommand = sqlstr
        Me.GridView1.DataSource = sds.Select(New DataSourceSelectArguments())
        Me.GridView1.DataBind()

        Me.Session.Clear()

    End Sub

    Protected Sub Button2_Click(ByVal sender As Object, ByVal e As EventArgs) Handles Button2.Click
        Response.Redirect("default.aspx")
    End Sub
End Class