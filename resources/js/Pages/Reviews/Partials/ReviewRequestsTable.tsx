import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/NewComponents/components/table";
import { format } from 'date-fns';
import parsePhoneNumber from "libphonenumber-js";
import { SimplePagination } from "@/NewComponents/components/shared/simple-pagination";
import { AtSymbolIcon, HashtagIcon } from "@heroicons/react/16/solid";
import {PaginatedResponse, ReviewRequest} from "@/types";

export function ReviewRequestsTable({data}: {data: PaginatedResponse<ReviewRequest>}) {
  const contacts = data.data;

  return <>
    <Table className="[--gutter:theme(spacing.6)] sm:[--gutter:theme(spacing.8)]">
      <TableHead>
        <TableRow>
          <TableHeader className="w-[100%]">Contact</TableHeader>
          <TableHeader>Added</TableHeader>
        </TableRow>
      </TableHead>
      <TableBody>
        {contacts.map((user) => (
          <TableRow key={user.value}>
            <TableCell className=" flex items-center gap-2.5">
              {user.value.startsWith('+') ? (
                <div className="flex items-center justify-center rounded-full w-6 h-6 bg-[#e8d5e3] text-[#8c4d7b] font-bold">
                  <HashtagIcon className="w-4"/>
                </div>
              ): (
                <div className="flex items-center justify-center rounded-full w-6 h-6 bg-[#D5E3E8] text-[#4d7b8c] font-bold text-[14px] ">
                  <AtSymbolIcon className="w-4" />
                </div>
              )}
              {
                user.value.startsWith('+') ?
                  parsePhoneNumber(user.value)?.formatNational()
                  : user.value
              }
            </TableCell>

            <TableCell>{format(user.review_request_sent_at, "PPpp")}</TableCell>
          </TableRow>
        ))}
      </TableBody>
    </Table>
    <SimplePagination pagination={data} />
  </>
}
