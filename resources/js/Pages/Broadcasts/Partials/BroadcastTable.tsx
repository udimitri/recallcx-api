import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/NewComponents/components/table";
import { format, formatDistance } from 'date-fns';
import { SimplePagination } from "@/NewComponents/components/shared/simple-pagination";
import {Broadcast, PaginatedResponse} from "@/types";
import {Badge} from "@/NewComponents/components/badge";

export function BroadcastTable({data}: {data: PaginatedResponse<Broadcast>}) {
  const broadcasts = data.data;

  return <>
    <Table className="[--gutter:theme(spacing.6)] sm:[--gutter:theme(spacing.8)]">
      <TableHead>
        <TableRow>
          <TableHeader>Send at</TableHeader>
          <TableHeader>Subject</TableHeader>
          <TableHeader>Status</TableHeader>
          <TableHeader>Created</TableHeader>
        </TableRow>
      </TableHead>
      <TableBody>
        {broadcasts.map((broadcast) => (
          <TableRow key={broadcast.id}>
            <TableCell>{format(broadcast.send_at, "PPPp")}</TableCell>
            <TableCell>{broadcast.subject}</TableCell>
            <TableCell>{broadcast.status === 'created'
              ? <Badge color="zinc">Scheduled</Badge>
              : broadcast.status === 'sending'
                ? <Badge color="purple">Sending</Badge>
                : <Badge color="green">Finished</Badge>
            }</TableCell>
            <TableCell className="text-zinc-500">{formatDistance(broadcast.created_at, new Date())} ago</TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
    <SimplePagination pagination={data} />
  </>
}
