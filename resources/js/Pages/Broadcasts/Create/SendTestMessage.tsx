import { Button } from '@/NewComponents/components/button'
import { Dialog, DialogActions, DialogBody, DialogDescription, DialogTitle } from '@/NewComponents/components/dialog'
import { ErrorMessage, Field, Label } from '@/NewComponents/components/fieldset'
import { Input } from '@/NewComponents/components/input'
import {FormEvent, useState} from 'react'
import { CheckCircleIcon } from "@heroicons/react/20/solid";
import * as Tooltip from '@radix-ui/react-tooltip';
import {useForm} from "@inertiajs/react";

function Success({
  setIsOpen
}: {
  setIsOpen: (value: boolean) => void
}) {
  return <>
    <DialogBody>
      <div className="flex flex-col gap-3 items-center bg-green-50 p-4 rounded-xl text-center">
        <CheckCircleIcon className="w-14 text-green-500"/>
        <p className="text-green-700 text-sm font-bold">Test messages sent successfully!</p>
        <p className="text-green-700 text-sm">
          Check your phone for a text message and your inbox for an email.
        </p>
        <p className="text-xs text-zinc-500">In some cases, it may take a few minutes to receive the messages.</p>
      </div>
    </DialogBody>
    <DialogActions>
      <Button onClick={() => setIsOpen(false)}>Close window</Button>
    </DialogActions>
  </>;
}

function Form({
  setIsOpen,
  setIsSuccess,
  subject,
  message
}: {
  setIsOpen: (value: boolean) => void,
  setIsSuccess: (value: boolean) => void,
  subject: string,
  message: string,
}) {
  const {data, setData, post, processing, errors, transform} = useForm({
    email_address: '',
    phone_number: '',
    subject: subject,
    message: message,
  });

  function sendBroadcast(e: FormEvent) {
    e.stopPropagation();
    e.preventDefault();

    post(route('broadcasts.send-test'), {
      onSuccess: () => setIsSuccess(true),
    })
  }

  return <>
    <form onSubmit={sendBroadcast}>
      <DialogBody>
        <div className="flex flex-col w-full gap-5">
          <Field>
            <Label>Email address</Label>
            <Input type="email" placeholder="you@example.com" value={data.email_address} onChange={e => setData('email_address', e.target.value)}/>
            {errors.email_address && <ErrorMessage>{errors.email_address}</ErrorMessage>}
          </Field>

          <Field>
            <Label>Phone number</Label>
            <Input type="tel" placeholder="7801234567" value={data.phone_number} onChange={e => setData('phone_number', e.target.value)}/>
            {errors.phone_number && <ErrorMessage>{errors.phone_number}</ErrorMessage>}
          </Field>
        </div>
      </DialogBody>
      <DialogActions>
        <Button plain onClick={() => setIsOpen(false)} disabled={processing}>
          Cancel
        </Button>
        <Button type="submit" disabled={processing}>Send test message</Button>
      </DialogActions>
    </form>
  </>
}

export function SendTestMessage({
  subject,
  message
}: {
  subject: string,
  message: string,
}) {
  let [isOpen, setIsOpen] = useState(false)
  let [isSuccess, setIsSuccess] = useState(false)

  function openDialog() {
    setIsSuccess(false);
    setIsOpen(true);
  }

  const isIncomplete = !subject.trim() || !message.trim();

  return (
    <>
    {isIncomplete
      ? <Tooltip.Provider>
        <Tooltip.Root delayDuration={10}>
          <Tooltip.Trigger asChild>
            <Button className="mt-3" type="button" color={'sky'} disabled={true}>
              Send test message
            </Button>
          </Tooltip.Trigger>
          <Tooltip.Portal>
            <Tooltip.Content
              className="z-50 overflow-hidden rounded-md bg-black px-3 py-1.5 text-sm text-white animate-in fade-in-0 zoom-in-95 data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=closed]:zoom-out-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2"
              sideOffset={5}
            >
              A subject and message are required to send a test message.
            </Tooltip.Content>
          </Tooltip.Portal>
        </Tooltip.Root>
      </Tooltip.Provider>
    : <Button className="mt-3" type="button" color={'sky'} onClick={() => openDialog()}>
        Send test message
      </Button>}

      <Dialog open={isOpen} onClose={() => false}>
        <DialogTitle>Send test message</DialogTitle>
        <DialogDescription>
          Preview your broadcast by sending yourself a test SMS & email message.
        </DialogDescription>
        {isSuccess
          ? <Success setIsOpen={setIsOpen}/>
          : <Form
            subject={subject}
            message={message}
            setIsOpen={setIsOpen}
            setIsSuccess={setIsSuccess}
          />
        }
      </Dialog>
    </>
  )
}
