{extends file="lib/framework/base.html"}
{block name="title"}方案列表{/block}
{block name="right"}
	<div class="right">
		<div class="head"><a class="first">邮件方案列表</a><a href="" class="second">添加邮件方案</a></div>
		<table class="project">
			<th>序号</th>
			<th>名称</th>
			<th>发送时间</th>
			<th>结束时间</th>
			<th>发送数</th>
			<th>打开数</th>
			<th>打开率</th>
			<th>打开uv</th>
			<th>uv打开率</th>
			<th>回访数</th>
			<th>回访率</th>
			<th>回访uv</th>
			<th>uv回访率</th>
			<th>修改</th>
			<th>删除</th>
			<th>添加用户</th>
			{foreach from=$data item=project}
			<tr>
				<td>{$project['pid']}</td>
				<td>{$project['subject']}</td>
				<td>{$project['sendtime']}</td>
				<td>{$project['last_sendtime']}</td>
				<td>{$project['sendnum']}</td>
				<td>{$project['opens']}</td>
				<td>{$project['opens_rate']}</td>
				<td>{$project['peropens']}</td>
				<td>{$project['peropens_rate']}</td>
				<td>{$project['transfer']}</td>
				<td>{$project['transfer_rate']}</td>
				<td>{$project['pertransfer']}</td>
				<td>{$project['pertransfer_rate']}</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			{/foreach}
		</table>
	</div>
{/block}
