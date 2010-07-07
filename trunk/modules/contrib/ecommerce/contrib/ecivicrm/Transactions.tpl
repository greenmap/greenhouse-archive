{if ($transactions)}
  {php}
     $transactions =& $this->_tpl_vars['transactions'];
  {/php}
  <div id="transactions">
    <div class="form-item">
      {strip}
      <table>
      <tr class="columnheader">
        <th>{ts}ID{/ts}</th>
        <th>{ts}Payment Status{/ts}</th>
        <th>{ts}Workflow{/ts}</th>
        <th>{ts}Total{/ts}</th>
        <th>{ts}Created{/ts}</th>
        <th>{ts}Due Date{/ts}</th>
        <th>{ts}Operations{/ts}</th>
      </tr>
      {foreach from=$transactions item=txn}
      {php}
        $txn =& $this->_tpl_vars['txn'];
      {/php}
      <tr class="{cycle values="odd-row,even-row}">
        <td>{$txn->txnid}</td>
        <td>
        {php}
        echo payment_get_status($txn->payment_status);
        {/php}
        </td>
        <td>
        {php}
        echo transaction_get_workflow($txn->workflow);
        {/php}
        </td>
        <td align="right">
        {php}
        echo payment_format($txn->gross);
        {/php}
        </td>
        <td>
        {php}
        echo format_date($txn->created, 'small');
        {/php}
        </td>
        <td>
        {php}
        if ($txn->duedate) {
          echo format_date($txn->duedate, 'small');
        }
        {/php}
        </td>
        <td></td>
      </tr>
      {/foreach}
      </table>
      {/strip}
    </div>
  </div>
{else}
  <div class="messages status">
    <dl>
        <dt><img src="{$config->resourceBase}i/Inform.gif" alt="{ts}status{/ts}"></dt>
        <dd>{ts}There are no Transactions for this contact{/ts}</dd>
    </dl>
  </div>
{/if}
