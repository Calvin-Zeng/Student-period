USE [Trains]
GO
/****** Object:  Table [dbo].[stations]    Script Date: 12/17/2012 10:27:28 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[stations](
	[station_id] [int] NOT NULL,
	[station_name] [varchar](30) NULL,
 CONSTRAINT [PK_stations] PRIMARY KEY NONCLUSTERED 
(
	[station_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY],
UNIQUE NONCLUSTERED 
(
	[station_id] ASC
)WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING OFF
GO
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (1, N'台北')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (2, N'板橋')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (3, N'桃園')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (4, N'新竹')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (5, N'台中')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (6, N'嘉義')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (7, N'台南')
INSERT [dbo].[stations] ([station_id], [station_name]) VALUES (8, N'左營')
