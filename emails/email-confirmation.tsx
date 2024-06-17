import {
  Body,
  Container,
  Head,
  Heading,
  Html,
  Link,
  Text,
  Tailwind,
} from "@react-email/components";
import * as React from "react";
import { emailTailwindConf } from "./config";

interface EmailConfirmationEmailProps {
  companyName: string;
  discount: string;
  unsubscribeUrl: string;
}

export const EmailConfirmationEmail = ({
  companyName,
  discount,
  unsubscribeUrl
}: EmailConfirmationEmailProps) => {
  return (
    <Html>
      <Head/>
      <Tailwind config={emailTailwindConf}>
        <Body className="bg-white my-auto mx-auto font-sans px-2">
          <Container className="border border-solid border-[#eaeaea] rounded-lg mt-[40px] mx-auto p-[20px] max-w-[465px]">
            <Heading className="text-black text-[38px] font-normal text-center p-0 mb-0 leading-none">
              🎉🎉🎉
            </Heading>
            <Heading className="text-black text-[24px] font-normal text-center p-0 mt-[20px] mb-[30px] mx-[30px]">
              <strong>{companyName}</strong> wants to give you <strong>{discount}</strong>!
            </Heading>

            <Text className="text-black text-[14px] leading-[24px]">
              Thanks for sharing your email! Show this email to our team member to
              receive <strong>{discount}</strong> your purchase.
            </Text>

            <Text className="text-black text-[14px] leading-[24px]">
              Keep an eye on your inbox for exclusive deals, special offers and updates on new products. You can
              unsubscribe at any time.
            </Text>
          </Container>
          <Container className="mt-[10px] text-center text-[#bbbbbb] ">
            <Text className="leading-none mb-0 text-[12px]">
              {companyName}
            </Text>
            <Text className="leading-none mt-[2px] text-[12px]">
              12529 102 Ave NW, Edmonton, AB T5N 0M4
            </Text>
            <Text className="leading-none mt-0 text-[12px]">
              If you would like to stop receiving emails,
              you can <Link href={unsubscribeUrl} className="text-[#bbbbbb] underline">unsubscribe</Link>.
            </Text>
          </Container>
        </Body>
      </Tailwind>
    </Html>
  );
};

EmailConfirmationEmail.PreviewProps = {
  companyName: "CHIC Circular Fashion",
  discount: "$5 off",
} as EmailConfirmationEmailProps;

export default EmailConfirmationEmail;
