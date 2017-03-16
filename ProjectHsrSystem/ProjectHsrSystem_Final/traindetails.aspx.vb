Public Class traindetails
    Inherits System.Web.UI.Page
    Protected Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs) Handles Me.Load
        Dim st As Integer
        st = Request.QueryString("station")
        Dim sds As New SqlDataSource
        Dim sqlstr As String
        Label1.Text = st.ToString & "車次    " & Session("startstation") & "→" & Session("endstation")
        sds.ConnectionString = "Data Source=.\;Initial Catalog=Trains;Integrated Security=True"
        sqlstr = "select timeline_station as 站名, timeline_time as 開車時間 from timeline where train_id = '" & st & "'"

        sds.SelectCommand = sqlstr
        Me.GridView1.DataSource = sds.Select(New DataSourceSelectArguments())
        Me.GridView1.DataBind()
    End Sub
End Class